<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')
    // ->select('logo','hospital_name','hospital_name','addrress1','telephone1')
    ->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employee Separation</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->


    <style>
        @page {
            padding-bottom: 100px;
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
            padding: 0px 20px 0px 20px;
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
                    <div style="text-align: center;"> <strong> Employee Separation</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>SL</strong>
                </th>

                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Emp ID</strong>
                </th>
                <th class="text-left" style="text-align: center; " scope="col">
                    <strong>Name</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Designation</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Joining Date</strong>
                </th>
                <th class="text-left" style="text-align: center;  width: 120px;" scope="col">
                    <strong>Job Length</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Date of application</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Type</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Exp. Date of Separation</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Last Working Day</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Remarks</strong>
                </th>
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Status</strong>
                </th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if (isset($separation_search_data))
                @foreach ($separation_search_data as $data)
                    <tr class="tr_border">
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ $loop->iteration }}</td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ $data->emp_seprtn_person_no_fk }}</td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ $data->employee_name }}</td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ $data->designation_name }}</td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ !empty($data->join_date) ? date('Y/m/d', strtotime($data->join_date)) : '' }}</td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ $data->job_length }}
                        </td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ !empty($data->emp_seprtn_application_date) ? date('Y/m/d', strtotime($data->emp_seprtn_application_date)) : '' }}
                        </td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ $data->seprtn_type }}
                        </td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ !empty($data->emp_seprtn_expected_date) ? date('Y/m/d', strtotime($data->emp_seprtn_expected_date)) : '' }}
                        </td>
                        <td class="text-left" style="text-align: center;" scope="col">
                            {{ !empty($data->last_working_day) ? date('Y/m/d', strtotime($data->last_working_day)) : '' }}
                        </td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ $data->emp_seprtn_application_remarks }}</td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ $data->save_option }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td style="width: 100%; " colspan="12">
                    <table style="width: 100%; ">
                        <tr>
                            <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                    <?php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format('g:i A');
                                    ?>
                                    {{ date('d/m/Y') }} {{ $date }}
                                </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                            <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                    [NextGen]
                                </strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
