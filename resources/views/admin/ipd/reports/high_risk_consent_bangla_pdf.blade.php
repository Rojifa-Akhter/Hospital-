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
    <title>Consent form</title>
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

        #pat_info tr td {
            /* border: 1px solid #222; */
            text-align: left;
        }

        li {
            margin-bottom: 5px;

        }

        #tbody_info {
            font-size: 14px;
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
                                <div style="">
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div>

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong> Consent Form(অনুমতি ফর্ম)</strong>
                        <div class="container">
                            <div style="text-align:left">
                                <h3>Patient Information</h3>
                            </div>
                            <div style=" border: 1 solid rgb(177, 175, 175);  border-radius: 5px;">
                                <table width="100%" style="border-collapse: separate; border:#222 1px solid"
                                    id="pat_info" cellpadding="1" cellspacing="0">
                                    <tr>
                                        <td colspan="2">
                                            <strong> Name of pt :</strong>
                                            {{ isset($pat_info->patient_name) ? $pat_info->patient_name : 'N/A' }}
                                        </td>
                                        <td>
                                            <strong>UHID No:</strong>
                                            {{ isset($pat_info->patient_code) ? $pat_info->patient_code : 'N/A' }}
                                        </td>
                                        <td>
                                            <strong>Age :</strong>
                                            {{ isset($pat_info->age) ? $pat_info->age : 'N/A' }}
                                        </td>
                                        <td>
                                            <strong>Sex :</strong>
                                            {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : 'N/A' }}
                                        </td>


                                    </tr>
                                    <tr>
                                        <td>
                                            <strong> B. Group :</strong>
                                            {{ isset($pat_info->blood_group_text) ? $pat_info->blood_group_text : 'N/A' }}
                                        </td>
                                        {{-- <td colspan="2">
                                            <strong> Department :</strong>
                                            {{ isset($pat_info->new_su_name) ? $pat_info->new_su_name : 'N/A' }}
                                        </td>
                                        <td>
                                            <strong>Ward :</strong>
                                            {{ isset($pat_info->new_ward_name) ? $pat_info->new_ward_name : 'N/A' }}
                                        </td>
                                        <td>
                                            <strong>Bed :</strong>
                                            {{ isset($pat_info->new_bed_name) ? $pat_info->new_bed_name : 'N/A' }}
                                        </td> --}}
                                        <td>
                                            <strong>Reg. Date</strong>
                                            {{ isset($pat_info->reg_date) ? $pat_info->reg_date : '' }}

                                        </td>
                                        <td colspan="3">
                                            <strong>Referred Doctor :</strong>

                                            {{ isset($pat_info->primary_doctor_name) ? $pat_info->primary_doctor_name : 'N/A' }}

                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

        </thead>
        <tbody id="tbody_info">
            <tr>
                <td colspan="12">
                    <ol>
                        <li>
                            I hereby authorized the doctor's of {{ Session::get('user.hospital_name') }}, to perform
                            the following procedures / operations.
                            <br>
                            আমি {{ Session::get('user.hospital_name_bangla') }}.-এর ডাক্তারদের নিম্নোক্ত অস্ত্রোপচার
                            করার সম্মতি দিলাম।
                        </li>
                        <li>
                            The procedures, their nature and consequences, as well as possible risks and complications
                            have been explained to me and I understand them well.
                            <br>
                            এই প্রক্রিয়া বা অস্ত্রোপচারের উদ্দেশ্য, প্রকৃতি এবং পরিণতি, এর ঝুঁকি বা জটিলতা সম্পর্কে
                            আমাকে অবহিত করা হয়েছে এবং আমি তা সঠিকভাবে অনুধাবন করেছি।
                        </li>
                        <li>
                            I recognise that during the course of the operations/procedures. Unexpected situations may
                            arise, demanding any extra procedure/operation to be performed. I do authorize the doctors
                            to perform these procedures.
                            <br>
                            আমি বিশ্বাস করি, উক্ত প্রক্রিয়া বা অস্ত্রোপচার চলাকালীন সময় অনভিপ্রেত কোন নুতন উপসর্গের জন্য
                            অস্ত্রোপচার বা বিকল্প প্রক্রিয়া প্রয়োজন অস্বাভাবিক নয়।
                        </li>
                        <li>
                            I consent to the administration of anesthesia. The mode of anesthesia (and the use of
                            anesthetic) is left to the discretion of the anesthetist as the deems advisable.
                            <br>
                            আমি নিজকে অজ্ঞান করার সম্মতি দিচ্ছি এবং অজ্ঞানের ধরণ বা প্রক্রিয়ার ব্যাপারে আমি বিশেষজ্ঞের
                            উপর পূর্ণ আস্থাশীল।
                        </li>
                        <li>
                            I am aware that the practice of medicine and surgery is not exact science and I acknowledge
                            that on guarantees have been made to me as to the results of the operation or procedure.
                            <br>
                            আমি ঘোষনা করছি যে, উক্ত অস্ত্রোপচার বা বিশেষ প্রক্রিয়ার 'সাফল্য সুনিশ্চিত' এমন ধারণা বা আশা
                            প্রদান করা হয়নি।
                        </li>
                        <li>
                            I further authorize {{ Session::get('user.hospital_name') }} and the doctors incharge to
                            carry our such diagnostic procedures administer blood transfusion, intravenous medication
                            deemed necessary and to make proper use of all tissues of anatomical part.
                            <br>
                            আমি {{ Session::get('user.hospital_name_bangla') }}.-এর ডাক্তারবৃন্দ বা বিশেষজ্ঞদের বিভিন্ন
                            রোগ নিরুপনী প্রক্রিয়া, রক্ত পরিসঞ্চালন ইন্ট্রাভেনাস চিকিৎসা বা অন্যান্য প্রক্রিয়া সম্পাদনের
                            সম্মতি প্রদান করছি।
                        </li>
                    </ol>
                    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" width="100%">
                        <tr>
                            <td style="padding-bottom: 12px;">Signature of patient.......</td>
                            <td style="padding-bottom: 12px;">Date..........</td>
                            <td style="padding-bottom: 12px;">Time.........</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 12px;">রোগীর স্বাক্ষর.........</td>
                            <td style="padding-bottom: 12px;">তারিখ.........</td>
                            <td style="padding-bottom: 12px;">সময়..........</td>
                        </tr>
                    </table>
                    In case of a minor, signatures of guardian, (I am the only legal guardian at the moment) <br>
                    (অপ্রাপ্ত বয়স্কদের জন্য অভিভাবকের স্বাক্ষর / আমি এই মুহুর্তে উপরোক্ত রোগী / রোগীনির একমাত্র বৈধ
                    অভিভাবক) স্বাক্ষর <br>
                    Witnesses / স্বাক্ষর

                    <table style="width: 100%;border-collapse:collapse;margin-top:10px" cellpadding="1" cellspacing="0"
                        width="100%">
                        <tr>
                            <td style="padding-bottom: 12px;">Sig..................</td>
                            <td style="padding-bottom: 12px;">Name..................</td>
                            <td style="padding-bottom: 12px;">Designation / Relation..................</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 12px;">স্বাক্ষর..................</td>
                            <td style="padding-bottom: 12px;">নাম..................</td>
                            <td style="padding-bottom: 12px;">পদবী / সম্পর্ক..................</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 12px;">Sig..................</td>
                            <td style="padding-bottom: 12px;">Name..................</td>
                            <td style="padding-bottom: 12px;">Designation / Relation..................</td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 12px;">স্বাক্ষর..................</td>
                            <td style="padding-bottom: 12px;">নাম..................</td>
                            <td style="padding-bottom: 12px;">পদবী / সম্পর্ক..................</td>
                        </tr>
                    </table>
                </td>
            </tr>

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
