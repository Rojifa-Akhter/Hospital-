<?php
$po_hospital_details = DB::table('WSEC_HOSPITAL')->first();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>print employee basic information</title>
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
                            {{-- <td style=" text-align:right; width: 15%;  border:none;">
                                <div style="">
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div>

                            </td> --}}
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Employee List</strong></div>
                </td>
            </tr>
            <tr class="tr_border">
                <th>#SL</th>
                {{-- <th>Image</th> --}}
                <th>Employee ID</th>
                <th style="word-wrap: break-word;">Name</th>
                <th style="word-wrap: break-word;">Last Name</th>
                {{-- <th>Age</th> --}}
                <th>Gender</th>
                <th>DOB</th>
                {{-- <th>Specialization</th> --}}
                <th>Designation</th>
                <th>Department</th>
                <th>Department Type</th>
                <th>Join Date</th>
                <th>Confirmation Date</th>
                <th>Contact</th>
                <th>Account No</th>
                <th style="word-wrap: break-word;">Address</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>


            @if (!empty($employee_info))
                @foreach ($employee_info as $employee)
                    <tr class="tr_border">
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        {{-- <td>
                    @if ($employee->photo_name != null)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $employee->photo_name) }}" width="50" style="border-radius: 50%;">
                    @else
                    @if ($employee->gender_txt == 'Male')
                    <img src="../public/images/doc-1.png" width="50">
                    @else
                    <img src="../public/images/nurse-2.png" width="50">
                    @endif
                    @endif

                </td> --}}
                        <td> {{ $employee->card_no }} </td>
                        <td style="word-wrap: break-word;"> {{ $employee->full_name }} </td>
                        <td style="word-wrap: break-word;"> {{ $employee->lname }} </td>
                        {{-- <td style="text-align: center;"> {{ $employee->age }} </td> --}}
                        <td> {{ $employee->gender_txt }} </td>
                        <td> 
                            @if (isset($employee->dob))
                            {{ date('d/m/Y', strtotime($employee->dob)) }}
                        @endif
                        </td>
                        {{-- <td> {{ $employee->specialization }} </td> --}}
                        <td> {{ $employee->designation }} </td>
                        <td> {{ $employee->su_name }} </td>
                        <td> {{ $employee->job_type }} </td>
                        <td>
                            @if (isset($employee->join_date))
                                {{ date('d/m/Y', strtotime($employee->join_date)) }}
                            @endif
                        </td>
                        <td>
                            @if (isset($employee->confirmation_date))
                                {{ date('d/m/Y', strtotime($employee->confirmation_date)) }}
                            @endif
                        </td>
                        <td> <b>Phone</b> <span>{{ $employee->phone_mobile }}</span><br> <b>Email</b>
                            <span> {{ $employee->email_personal }} </span>
                        </td>
                        <td>{{ $employee->bank_acc_no }}</td>
                        <td style="word-wrap: break-word;"> {{ $employee->pe_addr1 }} </td>

                        <td>
                            @if ($employee->status == 1)
                                <span class="badge badge-md badge-success"> Active</span>
                            @else
                                <span class="badge badge-md badge-secondary"> Inactive</span>
                            @endif
                        </td>

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
</body>

</html>
