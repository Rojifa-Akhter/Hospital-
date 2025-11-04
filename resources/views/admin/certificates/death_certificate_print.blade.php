<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Death Certificate</title>
    <style>
      @media print {
        body,
        page {
          margin: 0;
          box-shadow: 0;
        }
      }
      page[size="A4"] {
        width: 21cm;
        height: 29.7cm;
      }
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      body {
        font-family: sans-serif;
        width: 21cm;
        height: 29.7cm;
        margin: 0px auto;
      }
      .logo_box {
        width: 100px;
        height: auto;
        margin-left: auto;
      }
      .logo_box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
      }
      .main {
        border: 10px solid #b23b1b;
        padding: 20px;
      }
      .heading {
        text-align: center;
        margin-bottom: 25px;
      }
      .heading h2 {
        font-size: 20px;
        text-transform: uppercase;
      }
      .part_one {
        display: flex;
        justify-content: space-between;
      }
      .details_area {
        font-weight: 400;
        font-size: 14px;
        display: grid;
        grid-template-columns: 210px 30px auto;
        grid-gap: 5px;
        margin-bottom: 10px;
      }
      .details_area p:nth-child(1) {
        font-weight: 700;
      }
      .details_area2 {
        font-weight: 400;
        font-size: 14px;
        margin-bottom: 10px;
        display: flex;
        gap: 20px;
      }
      .details_area2 p:nth-child(1) {
        font-weight: 700;
      }
      .part_four {
        display: grid;
        grid-template-columns: 200px 40px auto;
        grid-gap: 10px;
        margin-bottom: 10px;
        margin-top: 20px;
      }
      .part_four p {
        font-weight: 400;
        font-size: 14px;
        margin-bottom: 10px;
      }
      .part_five p {
        font-size: 14px;
        margin-bottom: 20px;
      }
      .details_area3 {
        display: grid;
        grid-template-columns: 230px 30px auto;
        gap: 20px;
        font-weight: 400;
        font-size: 14px;
        margin-bottom: 10px;
      }
      .details_area3 p:nth-child(1) {
        font-weight: 700;
      }
      .footer p {
        font-size: 10px;
      }
    </style>
  </head>
  <body>
    <page size="A4" id="">
      <div class="logo_box">
        {{-- <img src="img/devine-logo.png" alt="logo" /> --}}

        <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                    alt="logo">
      </div>
      <?php
$data = json_decode(json_encode($report_data->certificate_json), true);
$strA = $data;
$arrDt = explode('^', $strA);
?>
      <div class="main">
        <div class="heading">
          <h2>DEATH CERTIFICATE</h2>
        </div>

        <div class="part_one">
          <div class="left">
            <div class="details_area">
              <p>UHID</p>
              <p>:</p>
              <p><?php print_r($arrDt[4]); ?></p>
            </div>
            <div class="details_area">
              <p>Patients Name</p>
              <p>:</p>
              <p>{{ !empty($report_header->patient_name) ? ucfirst($report_header->patient_name) : 'N/A' }}</p>
            </div>
          </div>
          <div class="right">
            <div class="details_area">
              <p>IP. No.</p>
              <p>:</p>
              <p>{{ !empty($report_header->admission_uid) ? $report_header->admission_uid : 'N/A' }}</p>
            </div>
            <div class="details_area">
              <p>Ward</p>
              <p>:</p>
              <p>{{ !empty($report_header->ward_name) ? ucfirst($report_header->ward_name) : 'N/A' }}</p>
            </div>
          </div>
        </div>
        <div class="part_two">
          <div class="details_area2">
            <p>Pt. Father’s / Husband’s Name</p>
            <p>:</p>
            <p>{{ !empty($report_header->father_name) ? ucfirst($report_header->father_name) : 'N/A' }}</p>
          </div>
          <div class="details_area2">
            <p>Address</p>
            <p>:</p>
            <p>{{ !empty($report_header->reg_present_addr) ? ucfirst($report_header->reg_present_addr) : 'N/A' }}</p>
          </div>
        </div>
        <div class="part_one">
          <div class="left">
            <div class="details_area">
              <p>City</p>
              <p>:</p>
              <p>{{ !empty($report_header->reg_present_addr) ? ucfirst($report_header->reg_present_addr) : 'N/A' }}</p>
            </div>
            <div class="details_area">
              <p>Telephone</p>
              <p>:</p>
              <p>{{ !empty($report_header->mobile1) ? $report_header->mobile1 : 'N/A' }}</p>
            </div>
            <div class="details_area">
              <p>Time Of Admission</p>
              <p>:</p>
              <p>{{ !empty($report_header->admission_date) ? date('h:i:s A', strtotime($report_header->admission_date)) : 'N/A' }}</p>
            </div>
            <div class="details_area">
              <p>Time Of Death/Certifying Death</p>
              <p>:</p>
              <p><?php print_r($arrDt[12]); ?></p>
            </div>
          </div>
          <div class="right">
            <div class="details_area">
              <p>Country</p>
              <p>:</p>
              <p>{{ !empty($report_header->pat_country) ? ucfirst($report_header->pat_country) : 'N/A' }}</p>
            </div>
            <div class="details_area">
              <p>Email</p>
              <p>:</p>
              <p>{{ !empty($report_header->pat_email) ? $report_header->pat_email : 'N/A' }}</p>
            </div>
            <div class="details_area">
              <p>Date Of Admission</p>
              <p>:</p>
              <p>{{ !empty($report_header->admission_date) ? date('d-m-Y', strtotime($report_header->admission_date)) : 'N/A' }}</p>
            </div>
            <div class="details_area">
              <p>Date Of Death</p>
              <p>:</p>
              <p><?php print_r($arrDt[11]); ?></p>
            </div>
          </div>
        </div>
        <div class="part_four">
          <div><p style="font-weight: 700">Diagnosis</p></div>
          <div>:</div>
          <div>
            {{-- <p>ACUTE KIDNEY INJURY</p>
            <p>HYPOVOLEMIC SHOCK</p>
            <p>LUCS DONE ON 2.02.2017</p>
            <p>MULTI-ORGAN FAILURE</p>
            <p>PRIMARY PPH WITH SEVERE ANAEMIA</p> --}}
            <p><?php print_r($arrDt[9]); ?></p>
          </div>
        </div>

        <div class="part_four">
          <div><p style="font-weight: 700">Cause of Death</p></div>
          <div>:</div>
          <div>
            {{-- <p>ASYSTOLIC CARDIAC ARREST</p>
            <p>SEPTICAEMIA WITH SEPTIC SHOCK</p>
            <p>MULTIORGAN FAILURE</p> --}}
            <p><?php print_r($arrDt[10]); ?></p>
          </div>
        </div>
        <div class="part_five">
          <p>
            <strong
              >The above named patient is certified Dead at <?php print_r($arrDt[12]); ?> <?php print_r($arrDt[11]); ?></strong
            >
          </p>
        </div>

        <div class="part_two">
          <div class="details_area3">
            <p>Name of Primary Consultant</p>
            <p>:</p>
            <p>{{ !empty($report_header->primary_doctor_name) ? ucfirst($report_header->primary_doctor_name) : 'N/A' }}</p>
          </div>
          <div class="details_area3">
            <p>Specialty</p>
            <p>:</p>
            <p>{{ !empty($report_header->serviceunit_name) ? ucfirst($report_header->serviceunit_name) : 'N/A' }}</p>
          </div>
          <div class="details_area3" style="margin-bottom: 50px">
            <p>Signature</p>
            <p>:</p>
            <p></p>
          </div>
        </div>
        <div class="part_two">
          <div class="details_area3">
            <p>Name of ICU Consultant</p>
            <p>:</p>
            <p>{{ !empty($report_header->icu_doctor_name) ? ucfirst($report_header->icu_doctor_name) : 'N/A' }}</p>
          </div>
        </div>
        <div class="part_two">
          <div class="details_area3">
            <p>Name of Doctor Certifying Death</p>
            <p>:</p>
            <p>{{ !empty($report_header->death_declared_doctor) ? ucfirst($report_header->death_declared_doctor) : 'N/A' }}</p>
          </div>
          <div class="details_area3">
            <p>Designation</p>
            <p>:</p>
            <p></p>
          </div>
          <div class="details_area3">
            <p>Specialty</p>
            <p>:</p>
            <p>{{ !empty($report_header->deathserdept) ? ucfirst($report_header->deathserdept) : 'N/A' }}</p>
          </div>
          <div class="details_area3" style="margin-bottom: 50px">
            <p>Signature</p>
            <p>:</p>
            <p></p>
          </div>
        </div>
      </div>
      <div class="footer">
        <p>
          <span> {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span>
          <span>phone: {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>

          <span>Email: {{ isset($po_hospital_details->email) ? $po_hospital_details->email : '' }}</span>
          <span>website: {{ isset($po_hospital_details->website) ? $po_hospital_details->website : '' }}</span>
        </p>
      </div>
    </page>
  </body>
</html>
