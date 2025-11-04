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
    <title>report</title>
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
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }
        .text-left{
            text-align: left;
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
                                <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
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
                                <div style="">
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Current Medicine Stock</strong> </div>
                </td>
            </tr>
            <tr class="tr_border">
                <th class="bg-soft-green text-center">SL#</th>
                <th class="bg-soft-green text-left" scope="col">Image</th>
                <th class="bg-soft-green text-left" scope="col">Doc-ID</th>
                <th class="bg-soft-green text-left" scope="col" style="word-wrap: break-word;">Name</th>
                <th class="bg-soft-green text-left" scope="col">Age</th>
                <th class="bg-soft-green text-left" scope="col">Gender</th>
                <th class="bg-soft-green text-left" scope="col">Specialization</th>
                <th class="bg-soft-green text-left" scope="col">Designation</th>
                <th scope="col" class="bg-soft-green text-left">Department</th>
                <th scope="col" class="bg-soft-green text-left">Contact</th>
                <th scope="col" class="bg-soft-green text-left" style="word-wrap: break-word;">Address</th>
                <th scope="col" class="bg-soft-green text-left">Email</th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if(!empty($sql))

            @foreach($sql as $key=>$row)
            <tr class="tr_border">
                <td class="border-1 bg-light text-center  " style="text-align: center;">{{ $loop->iteration }}</td>
                <td class="border-1 bg-light text-left">
                    @if($row->photo_name !=null)
                    <img src="../public/images/uploads/doctor_images/thumb, {{$row->photo_name}}" width="50" style="border-radius: 50%;">

                    @else
                    <img src="../public/images/no-photo.png" width="50">
                    @endif
                </td>
                <td class="border-1 bg-light text-left "><strong>{{ $row->person_code }}</strong></td>
                <td class="border-1 bg-light text-left " style="word-wrap: break-word;">{{ $row->full_name }}</td>
                <td class="border-1 bg-light text-left ">{{ $row->age }}</td>
                <td class="border-1 bg-light text-left ">{{ $row->gender_txt }}</td>
                <td class="border-1 bg-light text-left ">{{ $row->specialization }}</td>

                <td class="border-1 bg-light text-left ">{{$row->designation}}</td>
                <td class="border-1 bg-light text-right ">{{ $row->su_name }}</td>
                <td class="border-1 bg-light text-right ">{{ $row->phone_mobile }}</td>
                <td class="border-1 bg-light text-right " style="word-wrap: break-word;">{{ $row->pe_addr1 }}</td>
                <td class="border-1 bg-light text-right ">{{$row->email_personal }}</td>
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
                            <td style="font-size: 9px;  border:none;"><strong>Powered By - H360 [NextGen]
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
