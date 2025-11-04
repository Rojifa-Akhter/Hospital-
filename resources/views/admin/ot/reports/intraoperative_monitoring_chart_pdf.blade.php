<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intraoperative Monitoring Chart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #e9f5fb;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #2c3e50;
        }

        .patient-info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .patient-info label {
            margin: 10px 0;
            flex-basis: 48%; /* Responsive width */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #3498db;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="date"]:focus {
            border-color: #2980b9;
            outline: none; /* Remove outline */
        }

        .haemodynamic-info {
            margin-top: 20px;
            text-align: center;
        }

        .haemodynamic-indicators, .operation-indicators {
            display: flex;
            justify-content: space-around;
            margin: 10px 0;
        }

        .cvp-table {
            margin-top: 20px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 10px;
            text-decoration: none; /* Remove underline */
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Intraoperative Monitoring Chart</h1>
        
        <div class="patient-info">
            <label>Name of Patient: <input type="text" name="patient-name"></label>
            <label>Patient ID: <input type="text" name="patient-id"></label>
            <label>Age: <input type="text" name="patient-age"></label>
            <label>Sex: <input type="text" name="patient-sex"></label>
            <label>Blood Group: <input type="text" name="patient-blood-group"></label>
            <label>Department: <input type="text" name="department"></label>
            <label>Ward: <input type="text" name="ward"></label>
            <label>Name of Treating Doctor: <input type="text" name="doctor-name"></label>
            <label>Date: <input type="date" name="date"></label>
        </div>

        <h2>Drugs & Infusions</h2>
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>10</th>
                    <th>20</th>
                    <th>30</th>
                    <th>40</th>
                    <th>50</th>
                    <th>00</th>
                    <th>10</th>
                    <th>20</th>
                    <th>30</th>
                    <th>40</th>
                    <th>50</th>
                    <th>00</th>
                    <th>10</th>
                    <th>20</th>
                    <th>30</th>
                    <th>40</th>
                    <th>50</th>
                    <th>00</th>
                    <th>10</th>
                    <th>20</th>
                    <th>30</th>
                    <th>40</th>
                    <th>50</th>
                    <th>00</th>
                    <th>10</th>
                    <th>20</th>
                    <th>30</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Drugs</td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                </tr>
                <tr>
                    <td>Fluids</td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                    <td><input type="text"></td>
                </tr>
            </tbody>
        </table>

        <h2>Haemodynamic Monitoring</h2>
        <div class="haemodynamic-info">
            <label>Time: <span>10 20 30 40 50 00 10 20 30 40 50 00 10 20 30 40 50 00 10 20 30 40 50 00 10 20 30 40 50 00</span></label>
            <div class="haemodynamic-indicators">
                <div>SBP ˅</div>
                <div>DBP ˄</div>
                <div>MAP x</div>
                <div>HR ●</div>
                <div>SpO2 %</div>
            </div>
            <div class="operation-indicators">
                <div>Op start Ο</div>
                <div>Op end Θ</div>
                <div>Induction Ɪ</div>
                <div>Intubation ↓</div>
                <div>Extubation ↑</div>
            </div>
        </div>

        <h2>CVP</h2>
        <table class="cvp-table">
            <thead>
                <tr>
                    <th>240</th>
                    <th>220</th>
                    <th>200</th>
                    <th>180</th>
                    <th>160</th>
                    <th>140</th>
                    <th>120</th>
                    <th>100</th>
                    <th>80</th>
                    <th>60</th>
                    <th>40</th>
                    <th>20</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="12"><input type="text" placeholder="Enter CVP readings"></td>
                </tr>
            </tbody>
        </table>

        <div class="signatures">
            <label>Anesthesia Assistant: <input type="text" name="anesthesia-assistant"></label>
            <label>Anesthesiologist: <input type="text" name="anesthesiologist"></label>
        </div>
        
        <div style="text-align: center;">
            <a href="#" class="button">Save</a>
            <a href="#" class="button">Submit</a>
        </div>
    </div>
</body>
</html>
