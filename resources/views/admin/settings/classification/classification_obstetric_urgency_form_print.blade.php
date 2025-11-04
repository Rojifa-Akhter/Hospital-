<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OT Checklist Form</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            border: 1px solid #000;
            padding: 12px;
        }

        .no-border {
            border: none !important;
        }

        .center-text {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .page-break {
            page-break-before: always;
        }
    </style>


</head>

<body onload="window.print()">
    <div class="anaesthetic__form">
        <form action="" method="post" id="">
            @csrf

            <div class="container-fluid mt-5">
                <table>
                    <tr>
                        <td colspan="1" class="center-text bold"><u>Classification of Obstetric Urgency</u></td>

                    </tr>
                    <tr>
                        <td>
                            In obstetric surgery: degree of urgency for caesarean section relating to the presence
                            or absence of maternal or fetal compromise:
                        </td>
                    </tr>
                    <tr>
                        <td class="ps-5"><strong>Category 1:</strong>Immediate threat to life of mother or fetus.</td>
                    </tr>

                    <tr>
                        <td class="text-center"><strong>Decision to deliver time up to 30 mins.</strong></td>
                    </tr>
                    <tr>
                        <td class="ps-5"><strong>Category 2:</strong>Maternal or fetal compromise with no immediate
                            threat to life of mother or fetus.</td>
                    </tr>

                    <tr>
                        <td class="text-center"><strong>Decision to deliver time up to 1 hour.</strong></td>
                    </tr>
                    <tr>
                        <td class="ps-5"><strong>Category 3:</strong>Requires early delivery.</td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Decision to deliver time up to 24 hours.</strong></td>

                    </tr>
                    <tr>
                        <td class="ps-5"><strong>Category 4:</strong>No maternal or fetal compromise.</td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>At a time to suit the woman and maternity services.</strong>
                        </td>

                    </tr>
                </table> <br> <br> <br>

                <div class="page-break"></div>

                <table>
                    <tr>
                        <td colspan="1" class="center-text bold"><u>Classification of Surgical Urgency</u>
                        </td>

                    </tr>

                    <tr>
                        <td class="ps-5"><strong>Category 1 - Immediate means:</strong> Examples of Category 1
                            urgency include (Ruptured ectopic pregnancy, Ruptured spleen, Major gastrointestinal
                            bleed, Fracture with major neurovascular deficit). Immediate life, limb or organ-saving
                            surgical intervention required. Resuscitation simultaneous with intervention. </td>
                    </tr>

                    <tr>
                        <td class="text-center">Normally<strong> within minutes </strong>of decision to operate</td>
                    </tr>
                    <tr>
                        <td class="ps-5"><strong>Category 2- Urgent means: </strong>Examples of Category 2
                            surgical urgency cases include (Compound fracture, Perforated bowel with peritonitis,
                            Critical organ or limb ischemia). Intervention for acute onset or clinical deterioration
                            of potentially life-threatening conditions for fixation of many fractures and for relief
                            of pain.
                        </td>
                    </tr>

                    <tr>
                        <td class="text-center">Normally<strong> within hours </strong>of decision to operate</td>
                    </tr>
                    <tr>
                        <td class="ps-5"><strong>Category 3 -Expedited means:</strong> Examples of Category 3
                            surgical urgency cases include (Repair of tendon and nerve injuries, Excision of tumour
                            with potential to bleed or obstruct). Patients require early treatment where the
                            condition is not an immediate threat to life, limb or organ survival.
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">Normally<strong> within days of the decision </strong>to operate
                        </td>

                    </tr>
                    <tr>
                        <td class="ps-5"><strong>Category 4- Elective means:</strong> Examples of Category 4 cases
                            include (Non-obstructed/ non-incarcerated hernia repair, Circumcision for non-clinical
                            reasons).Intervention planned or booked in advance of routine admission to hospital.
                            Encompasses all conditions not classified as immediate, urgent or expedited.
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center"><strong>Timing to suit the patient, hospital and staff.
                            </strong></td>

                    </tr>
                </table>
            </div>


        </form>
    </div>


</body>

</html>
