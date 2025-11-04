@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    // dd( $hospital);
    $body_font_size = $po_hospital_details->hospital_code == 'GMC' ? 14 : 11;
    $footer_bottom = $po_hospital_details->hospital_code == 'GMC' ? 25 : 10;
    $signature_bottom = $po_hospital_details->hospital_code == 'GMC' ? 2.6 : 1.6;
    $body_top = $po_hospital_details->hospital_code == 'GMC' ? 3.8 : 3;
    $footer_border = $po_hospital_details->hospital_code == 'GMC' ? 'none' : '1px solid #000';
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>সম্মতি পত্র {{ $patient_data[0]->patient_name }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
    <style>
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
        /* header {
            position: fixed;
            top: 0;
            height: 2.5cm;
            border-bottom: 1px solid;
            padding-top: 10px;
        } */

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 1cm;
            margin-left: .3cm;
            margin-right: .5cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: <?=$body_font_size ?>px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 0.7cm;
            text-align: center;
            font-size: 9px;
            bottom: <?=$footer_bottom ?>px;
            /*border-top: 1px solid black;*/
            /* padding-top: 5px; */
            border-top: <?=$footer_border ?>;
        }

        .signature_ {
            position: fixed;
            bottom: <?=$signature_bottom ?>cm;
            left: .8cm;
            right: 1.6cm;
            width: 100%;
            /* text-align: center; */

            /* border-top: 1px solid; */
        }

        main tr {
            line-height: 30px;
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

        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'Helvetica';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        .page-break {
            page-break-after: always;
        }

        /*body part */
        .border-bottom {
            border-bottom: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .w-100 {
            width: 100%;
        }

        .w-50 {
            width: 50%;
        }

        .w-70 {
            width: 70%;
        }

        .w-30 {
            width: 30%;
        }
    </style>
</head>

<body onload="window.print()">
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            {{-- <tr style="">
                <td style="text-align:center;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="120"
                        alt="">
                </td>
            </tr> --}}

            <tr style="">
                <td style="text-align:center;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="120" alt="">
                </td>
                <td style="text-align:center;padding-right:160px;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                    <br>
                    Address:<span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone
                    No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header>
    <footer style="font-size:9px;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y h:i:s a');
                                @endphp
                                {{ $date }} Printed By:
                                <strong>{{ Session::get('user.ses_user_name') }}</strong>
                        </td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="admission_body text-center" style="margin-left:30px; text-align:right;">
            <p
                style="text-align: center;
            margin: 0 auto;
            padding: 5px;
            width: 30%;
            font-size: 20px !important;
            background: aliceblue;
            border: 2px solid #000;
            border-radius: 7px;
            font-family: vardana;
            font-weight: bold;
            ">
                সম্মতি পত্র</p>
            <span class="report-date"><strong style="text-align: right;">Date: ........................</strong>
            </span>
            <table style="width: 100%;">
                <tr style=" ">
                    <td style="text-align:left; width:66%;">
                        আমি আমার রোগী ইস্ট ওয়েস্ট মেডিকেল কলেজ ও হাসপাতাল এ সব-ইচ্ছায় ও সজ্ঞানে ভর্তি করেছি এবং ভর্তি
                        পরবর্তীতে রোগীর চিকিৎসার জন্য যে সকল ঔষধ প্রয়োজন হবে, সেই সকল ঔষধ হাসপাতালের নিজস্ব
                        ব্যবস্থাপনায় সরবরাহ করার অনুমতি প্রদান করিলাম । যাহার মূল্য আমরা হাসপাতালের ফার্মেসীতে পরিশোধ
                        করিতে বাধ্য থাকিব ।
                    </td>
                </tr>
            </table>
            <table style="width: 80%;">
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        অভিভাবক এর পূর্ণ নাম
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">

                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        সাক্ষর
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">

                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        মোবাইল
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">

                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        রোগীর পূর্ণাঙ্গ ভর্তি আইডি
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">
                        <strong>{{ $patient_data[0]->patient_code }}</strong>
                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        রোগীর নাম
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">
                        <strong>{{ $patient_data[0]->patient_name }}</strong>
                    </td>
                </tr>
            </table>

        </div>
    </main>

    <div class="" style="margin-top: 2cm;margin-left:30px;font-size:15px;border-bottom: 2px solid whitesmoke;margin-bottom: 5px;padding-bottom: 14px;">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; width:66%;">

                </td>
                <td style="width: 33%;text-align:right;">
                    <span style="padding:5px; border-top: black solid 1px;"> <strong> Pharmacy Deputy
                            Manager</span></strong>
                </td>
            </tr>
        </table>
    </div>


    {{-- 2nd part  --}}

    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            {{-- <tr style="">
                <td style="text-align:center;">
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="120"
                        alt="">
                </td>
            </tr> --}}

            <tr style="">
                <td style="text-align:center;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="120" alt="">
                </td>
                <td style="text-align:center;padding-right:160px;">
                    <span style="font-size: 15px;"> <strong>
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                    <br>
                    Address:<span>
                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone
                    No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
            </tr>
        </table>
    </header>
    <footer style="font-size:9px;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y h:i:s a');
                                @endphp
                                {{ $date }} Printed By:
                                <strong>{{ Session::get('user.ses_user_name') }}</strong>
                        </td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="admission_body text-center" style="margin-left:30px; text-align:right;">
            <p
                style="text-align: center;
            margin: 0 auto;
            padding: 5px;
            width: 30%;
            font-size: 20px !important;
            background: aliceblue;
            border: 2px solid #000;
            border-radius: 7px;
            font-family: vardana;
            font-weight: bold;
            ">
                সম্মতি পত্র</p>
            <span class="report-date"><strong style="text-align: right;">Date: ........................</strong>
            </span>
            <table style="width: 100%;">
                <tr style=" ">
                    <td style="text-align:left; width:66%;">
                        আমি আমার রোগী ইস্ট ওয়েস্ট মেডিকেল কলেজ ও হাসপাতাল এ সব-ইচ্ছায় ও সজ্ঞানে ভর্তি করেছি এবং ভর্তি
                        পরবর্তীতে রোগীর চিকিৎসার জন্য যে সকল ঔষধ প্রয়োজন হবে, সেই সকল ঔষধ হাসপাতালের নিজস্ব
                        ব্যবস্থাপনায় সরবরাহ করার অনুমতি প্রদান করিলাম । যাহার মূল্য আমরা হাসপাতালের ফার্মেসীতে পরিশোধ
                        করিতে বাধ্য থাকিব ।
                    </td>
                </tr>
            </table>
            <table style="width: 80%;">
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        অভিভাবক এর পূর্ণ নাম
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">

                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        সাক্ষর
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">

                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        মোবাইল
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">

                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        রোগীর পূর্ণাঙ্গ ভর্তি আইডি
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">
                        <strong>{{ $patient_data[0]->patient_code }}</strong>
                    </td>
                </tr>
                <tr style=" ">
                    <td style="text-align:left; width:30%;">
                        রোগীর নাম
                    </td>
                    <td style="text-align:left; width:10%;">
                        :
                    </td>
                    <td style="text-align:left; width:60%;">
                        <strong>{{ $patient_data[0]->patient_name }}</strong>
                    </td>
                </tr>
            </table>

        </div>
    </main>

    <div class="" style="margin-top: 2cm;margin-left:30px;font-size:15px;">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; width:66%;">

                </td>
                <td style="width: 33%;text-align:right;">
                    <span style="padding:5px; border-top: black solid 1px;"> <strong> Pharmacy Deputy
                            Manager</span></strong>
                </td>
            </tr>
        </table>
    </div>


</body>

</html>
