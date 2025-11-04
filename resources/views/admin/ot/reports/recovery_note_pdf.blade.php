<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recovery Room Note</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.5;
        }
        h1, h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .section {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <h1>Recovery Room Note</h1>

    <div class="section">
        <label for="regId">Reg Id:</label> <input type="text" id="regId" name="regId"><br>
        <label for="date">Date:</label> <input type="date" id="date" name="date"><br>
        <label for="time">Time:</label> <input type="time" id="time" name="time">
    </div>

    <div class="section">
        <label>Airway Device:</label>
        <select>
            <option value="nil">Nil</option>
            <option value="oral">Oral</option>
            <option value="nasal">Nasal</option>
            <option value="lma">LMA</option>
            <option value="oett">OETT</option>
            <option value="nett">NETT</option>
            <option value="tracheostomy">Tracheostomy</option>
        </select>
    </div>

    <div class="section">
        <label>Respiration:</label>
        <select>
            <option value="spontaneous">Spontaneous</option>
            <option value="assisted">Assisted</option>
            <option value="mechanical">Mechanical</option>
        </select>
    </div>

    <div class="section">
        <h2>Monitor in Recovery Room Chart</h2>
        <table>
            <tr>
                <th>Parameter</th>
                <th>Value</th>
            </tr>
            <tr>
                <td>Pulse</td>
                <td>●</td>
            </tr>
            <tr>
                <td>SBP</td>
                <td>˅</td>
            </tr>
            <tr>
                <td>DBP</td>
                <td>˄</td>
            </tr>
            <tr>
                <td>SpO2</td>
                <td></td>
            </tr>
            <tr>
                <td>Respiratory Rate</td>
                <td></td>
            </tr>
            <tr>
                <td>Pain Score (1-10)</td>
                <td></td>
            </tr>
            <tr>
                <td>Nausea/Vomiting Score</td>
                <td></td>
            </tr>
            <tr>
                <td>Urine (ml)</td>
                <td></td>
            </tr>
            <tr>
                <td>Drain (ml, if any)</td>
                <td></td>
            </tr>
            <tr>
                <td>Recovery Score</td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Medications at Recovery Room</h2>
        <table>
            <tr>
                <th>Time</th>
                <th>Drug/Dose/Route</th>
                <th>Sign</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Recovery Events Note (If any):</h2>
        <textarea rows="4" style="width: 100%;"></textarea>
    </div>

    <div class="section">
        <h2>Recovery Room Monitor Chart</h2>
        <table>
            <tr>
                <th>Time</th>
                <th>SBP</th>
                <th>DBP</th>
                <th>Pulse</th>
                <th>SpO2/O2 LPM</th>
                <th>Resp Rate</th>
                <th>Pain Score</th>
                <th>Nausea/Vomiting Score</th>
                <th>Urine</th>
                <th>Drain</th>
                <th>Recovery Score (…./16)</th>
            </tr>
            <tr>
                <td>00:00</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
    </div>

    <div class="section">
        <label>Discharge:</label>
        <select>
            <option value="cabin">Cabin</option>
            <option value="ward">Ward</option>
            <option value="post_op_ward">Post Operative Ward</option>
            <option value="hdu">HDU</option>
            <option value="icu">ICU</option>
        </select>
    </div>

    <div class="section">
        <label>Nurse In Charge:</label> <input type="text" id="nurseInCharge" name="nurseInCharge"><br>
        <label>Anesthesiologist:</label> <input type="text" id="anesthesiologist" name="anesthesiologist">
    </div>

</body>
</html>
