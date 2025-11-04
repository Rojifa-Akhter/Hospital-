<style>
    .board_member_img {
        border: 1px solid black;
        width: 50px;
    }


    @page {
        margin: .5cm .6cm;
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


    /** Define the header rules **/
    header {
        position: fixed;
        top: 0;
        height: 2cm;

        padding: 0 1cm;
    }

    header img {
        /*width: 80px;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 2cm;
        margin-left: .3cm;
        margin-right: .3cm;
        margin-bottom: 2cm;
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
        bottom: 2.6cm;
        left: .8cm;
        right: .8cm;
        width: 100%;
        /* text-align: center; */

        /* border-top: 1px solid; */
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attendance Request Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>

    </style>
</head>

<body>
    <header>
        <table style="width: 100%;" class="signature">
            <tr>
                <td style="width: 10%; text-align: center;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align: center; padding-right:80px;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: <span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>
                        {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span> <br>
                </td>
            </tr>
        </table>

    </header>

    <div class="signature_">
        {{-- <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Checked By
                    </span>
                </td>
                <td style="text-align:center; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Received By </span>
                </td>
                <td style="text-align:right; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                </td>
            </tr>
        </table> --}}

        {{-- <div> --}}
        <!-- <table style="width: 100%; border:none ">
                <tr>
                    <td colspan="2">Department Head Approval </td>
        
                    <td colspan="2" class="text-right">Managing Director Approval</td>
                </tr>
            </table> -->
     
        {{-- </div> --}}


    </div>

    <footer style="position: fixed;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y H:m:s');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT]
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="wrapper">
            <div style="text-align:center; margin-bottom:20px; margin-left:90px; margin-top:15px;" class="mb-2">
                <h3 class="report-name" style="margin-right:112px;">Attendance Request</h3>
            </div>
            <div style="width:100%; margin-bottom:5px" class="mb-2">
            </div>
            <section id="lp-items">
                <div class="container">
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr" style="background-color: #E3E3E3;">
                                <th style="text-align: center" scope="col">
                                    <strong>Name</strong>
                                </th>
                                <th style="text-align: center" scope="col">
                                    <strong>Attendance Date</strong>
                                </th>
                                <th style="text-align: center" scope="col">
                                    <strong>In Time</strong>
                                </th>
                                <th class="text-left" scope="col">
                                    <strong>Out Time</strong>
                                </th>
                                <th style="text-align: left" scope="col">
                                    <strong>Reason</strong>
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $implode_data = explode('||', $attendance_report_data->remarks);
                            @endphp
                                
                            <tr>
                                <td style="text-align: center">
                                    {{ $attendance_report_data->user_fullname }}
                                  </td>
                                <td style="text-align: center">
                                  @php  
                                  $date = explode(':', $implode_data[1] ?? '');
                                  @endphp
                                  {{ isset($date[1]) ? $date[1] : '' }}
                                </td>
                                <td style="text-align: center">
                                   @php
                                   $in = explode(' ', $implode_data[2] ?? '');
                                   @endphp
                                   {{ isset($in[3]) ? $in[3] : '' }}
                                </td>
                                <td style="text-align: center">
                                   @php
                                   $out = explode(' ', $implode_data[3] ?? ''); 
                                   @endphp 
                                   {{ isset($out[3]) ? $out[3] : '' }}
                                </td>
                                <td style="text-align: left">{{ $implode_data[0] ?? '' }}</td>
                                </tr>
                                
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
