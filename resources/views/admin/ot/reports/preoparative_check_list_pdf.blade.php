<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Preoperative Check List Report</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="Preoperative checklist report for patient management.">

    <style>
        @page {
            margin: .5cm .6cm;
            width: 100%;
            height: 100%;
        }

        @font-face {
            font-family: 'IBM Plex Sans';
            font-weight: normal;
            font-size: 9px;
            src: url("font url");
        }

        body {
            margin: 2cm 0.3cm 2cm 0.3cm; /* Added more space at the top */
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            font-size: 10px;
        }

        header, footer {
            position: fixed;
            left: 0cm;
            right: 0cm;
            border: 1px solid;
        }

        header {
            top: 0;
            height: 2cm;
            padding: 0 1cm;
        }

        footer {
            bottom: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #222;
            padding: 7px;
        }

        th {
            text-align: left;
        }

        .signature {
            margin-top: 20px;
        }

        .name-field {
            border-bottom: 1px solid #222;
            padding: 5px;
            display: inline-block;
            width: 200px;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;" class="signature">
            <tr>
                <td style="width: 15%; border:none;">
                    <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="Hospital Logo">
                </td>
                <td style="text-align:center; border:none;">
                    <strong style="font-size: 15px;">
                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                    </strong>
                    <br>
                    Address: <span>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                    Phone No: <span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                </td>
                <td style="text-align:right; width: 15%; border:none;">
                    <img src="data:image/png;base64, {{ $barcode_no }}" width="100" alt="Barcode">
                </td>
            </tr>
        </table>
    </header>

    <div style="text-align: center; padding:5px; margin-top: 2.5cm;"> <!-- Added margin-top -->
        <h2><strong>Preoperative Check List Report</strong></h2>
    </div>

    <section>
        <strong>Patient Information</strong>
        <table style="width: 100%; margin-top: 10px; border-collapse: collapse;">
            <tr>
                <td style="width: 25%; border: 1px solid #222; padding: 7px;">Name of patient:</td>
                <td style="width: 25%; border: 1px solid #222; padding: 7px;">Patient Id:</td>
                <td style="width: 25%; border: 1px solid #222; padding: 7px;">Age:</td>
                <td style="width: 25%; border: 1px solid #222; padding: 7px;">Sex:</td>
            </tr>
            <tr>
                <td style="border: 1px solid #222; padding: 7px;">Bl Group:</td>
                <td style="border: 1px solid #222; padding: 7px;">Department:</td>
                <td style="border: 1px solid #222; padding: 7px;">Ward:</td>
                <td style="border: 1px solid #222; padding: 7px;">Bed:</td>
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid #222; padding: 7px;">Date:</td>
            </tr>
            <tr>
                <td colspan="4" style="border: 1px solid #222; padding: 7px;">Name of Treating Doctor:</td>
            </tr>
        </table>
    </section>

    <section>
        <strong>Preoperative Checklist</strong>
        <table style="width: 100%; margin-top: 10px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #222; padding: 7px; text-align: left;">Sl</th>
                    <th style="border: 1px solid #222; padding: 7px; text-align: left;">Items</th>
                    <th style="border: 1px solid #222; padding: 7px; text-align: center;">Ward Nurse</th>
                    <th style="border: 1px solid #222; padding: 7px; text-align: center;">OR Nurse</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="border: 1px solid #222; padding: 7px;">1.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Correct patient ID, names, age, sex (patient identity)</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border: 1px solid #222; padding: 7px;">Nil by mouth as advised</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Dress Changed (Clean, Gowned and Cap)</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border: 1px solid #222; padding: 7px;">Ornaments/Jewelry/ Amulet /Nail polish removed</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Operation area clean & shaved</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border: 1px solid #222; padding: 7px;">Operation site marked</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>4.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Consent form and/ high risk form signed</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border: 1px solid #222; padding: 7px;">Pre-anesthesia assessment done</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>5.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Patient height, weight & BMI measured</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>6.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Blood is ready - Donor standby/ Blood deposited</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>7.</td>
                    <td style="border: 1px solid #222; padding: 7px;">HBsAg/HCV/HIV / Other …………………………….tested</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>8.</td>
                    <td style="border: 1px solid #222; padding: 7px;">All investigation reports with radiological films available (file complete)</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>9.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Intravenous access / SpO2 placed opposite to the operating site</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>10.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Allergies</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>11.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Pacemaker / Artificial Denture/Implant</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>12.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Anticoagulants in last 5 days</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>13.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Antihypertensive / Bronchodilator/ Other medication taken</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>14.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Hypoglycemic agent/ other (as adv) taken</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
                <tr>
                    <td>15.</td>
                    <td style="border: 1px solid #222; padding: 7px;">Voided urine</td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                    <td style="border: 1px solid #222; padding: 7px;"></td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <strong>Ward Nurse Name:</strong>
            <span class="name-field"></span>
            <strong style="margin-left: 20px;">Operating Room Nurse Name:</strong>
            <span class="name-field"></span>
        </div>
    </section>

    <footer>
        <p>© 2024 Hospital Name - All rights reserved.</p>
    </footer>

    <script>
        window.print();
        window.onafterprint = function() {
            window.close(); // Close the window after printing
        }
    </script>
</body>

</html>
