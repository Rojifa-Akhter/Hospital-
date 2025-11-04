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

    #lp-items {
    width: 100%;
  }

  .container {
    max-width: 100%;
    padding: 0;
  }

  table {
    width: 100%;
    border-collapse: collapse;
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
        /* height: 2cm; */
        padding: 0 1cm;
    }

    header img {
        /*width: 80px;*/
    }

    /** Define now the real margins of every page in the PDF **/
    body {
        margin-top: 2.5cm;
        margin-left: .3cm;
        margin-right: .3cm;
        margin-bottom: 2cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 9px;
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
    <title>General Consent</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>

<body>
    <header>
       <table style="width: 100%; margin-right: 40px;" class="signature">
            <tr>
                <td style="width: 10%; text-align: center;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60" alt="">
                </td>
                <td style="text-align: center;">
                    <span style="font-size: 15px;"> <strong> 
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </strong></span> <br>
                    Address: 
                    <span>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
                    <br>
                    Phone No:
                    <span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    <br>
                </td>
            </tr>
        </table>

    </header>

    <div class="signature_">
        <div class="singature" style="margin-top: -70px;">

        </div>
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
            <section id="lp-items">
                <div class="container">
                    <h2 style="text-align: center; text-decoration: underline;">GENERAL CONSENT</h2> <br> <br>
                    <p style="font-size: 1.4em;">{!! ($data) ? $data[0]->generalconsent_text : '' !!}</p>
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr2">   
                                <th style="width: 200px; height: 40px; !important" rowspan="2">Patient / Patient’s 
                                    Representative</th>
                                <th>Signature</th>
                                <th>Name</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td style="height: 80px;"></td>
                                <td style="height: 80px;"></td>
                                <td style="height: 80px;"></td>
                                <td style="height: 80px;"></td>
                            </tr>
                       </tbody>
                    </table> 
                    <br>
                    <h3>Office use only</h3>
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                        <thead>
                            <tr class="table-tr2">   
                                <th style="width: 200px; height: 40px; !important" rowspan="2">Customer Relation Staff</th>
                                <th>Signature</th>
                                <th>Name</th>
                                <th>Emp. ID</th>
                                <th>Date</th>
                                <th>Time</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td style="height: 80px;"></td>
                                <td style="height: 80px;"></td>
                                <td style="height: 80px;"></td>
                                <td style="height: 80px;"></td>
                                <td style="height: 80px;"></td>
                            </tr>
                       </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
</body>

</html>
