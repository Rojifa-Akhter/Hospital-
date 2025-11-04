  <!-- Bootstrap 5 CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display&display=swap"
      rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- Custom CSS for better card design and typography -->
  <style>
      body {
          font-family: 'Roboto', sans-serif;
          background-color: #f9fafb;
          /* Soft background color */
      }

      /* Dashboard Header with Soft Gradient */
      .dashboard-header {
          background: rgb(240 247 255);
          /* Light to lighter blue gradient */
          color: rgb(0, 0, 0);
          padding: 20px 10px;
          /* Minimized padding */
          border-radius: 10px;
          /* margin-bottom: 30px; */
          font-family: 'Playfair Display', serif;
          /* Elegant font for header */
      }

      .fixed .content-wrapper,
      .fixed .right-side {
          padding-top: 0px !important;
      }

      .card-header {
          background-color: #f0f7ff;
          /* Very soft blue background */
          font-weight: bold;
          color: #003366;
          /* Dark blue for card header text */
          font-family: 'Playfair Display', serif;
          /* Elegant, serif font */
      }

      .card-body {
          background-color: #ffffff;
          /* White body for cards */
          font-size: 1.2rem;
          font-family: 'Roboto', sans-serif;
          /* Simple and readable font */
          color: #555555;
          /* Dark gray text for readability */
      }

      .metric-card {
          margin-bottom: 20px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          border-radius: 10px;
          transition: all 0.3s ease-in-out;
          background-color: #ffffff;
          /* White for card bodies */
      }

      /* Card Hover Effect */
      .metric-card:hover {
          transform: translateY(-10px);
          box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
      }

      .metric-value {
          font-size: 2rem;
          font-weight: bold;
          color: #4e8be6;
          /* Soft blue for value */
      }

      /* Soft background color for cards */
      .card-soft {
          background-color: #f0f7ff;
          /* Light blue */
      }

      /* Graph Card Style */
      .graph-card {
          margin-top: 20px;
          transition: transform 0.5s ease;
          border-radius: 10px;
          background-color: #ffffff;
      }

      .graph-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
      }

      .container-fluid {
          padding-top: 20px;
      }

      /* Button and Input Hover Effects */
      .form-control:hover,
      .btn:hover {
          border-color: #007bff;
          box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2);
      }

      .btn {
          background-color: #007bff;
          color: white;
          border-radius: 5px;
          transition: all 0.3s ease;
      }

      .btn:hover {
          background-color: #0056b3;
      }

      .form-control {
          background-color: #ffffff;
          border: 1px solid #007bff;
          border-radius: 5px;
      }

      /* Spacing for row elements */
      .row {
          margin-bottom: 30px;
      }

      /* Card Footer */
      footer {
          background-color: #f1f8ff;
          color: #5a6f7d;
          padding: 15px 0;
      }

      footer p {
          margin: 0;
      }
  </style>
  <div class="container-fluid">
      <!-- Header Section -->
      <header class="dashboard-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Management Dashboard</h5>
          <form action="{{ route('report.cashier-wise-report-print') }}" id="searchForm" method="post" target="_blank">
              @csrf
              <div style="font-size: 15px;">
                  <label for="from-date" class="form-label mb-0">From:</label>
                  <input type="text" id="from-date" name="from-date"
                      class="form-control form-control-sm d-inline-block date_picker" placeholder="dd/mm/yyyy"
                      style="width: 130px;">

                  <label for="to-date" class="form-label mb-0" style="margin-left: 10px;">To:</label>
                  <input type="text" id="to-date" name="to-date"
                      class="form-control form-control-sm d-inline-block date_picker" placeholder="dd/mm/yyyy"
                      style="width: 130px;">

                  <button type="button" id="dashboard_search" class="btn btn-primary btn-md"
                      style="margin-left: 10px;">Search</button>

                  <label for="date-picker" class="form-label mb-0" style="margin-left: 20px;">Current Date:</label>
                  <span>{{ date('d/m/Y') }}</span>
              </div>
          </form>
      </header>


      <!-- OPD Count Section -->
      <div class="bg-info p-2" style="background-color: #94c8d147 !important;">
          <div class="row" id="opd-metrics">
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">New Registration</div>
                      <div class="card-body">
                          <div><span class="metric-value"
                                  id="newRegistration">{{ $opdData['newRegistration'] ?? 0 }}</span></div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">OPD Consultations</div>
                      <div class="card-body">
                          <div><span class="metric-value"
                                  id="opdConsultations">{{ $opdData['opdConsultations'] ?? 0 }}</span></div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">OPD Head Count</div>
                      <div class="card-body">
                          <div><span class="metric-value" id="opdHeadCount">{{ $opdData['opdHeadCount'] ?? 0 }}</span>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">ER Visits</div>
                      <div class="card-body">
                          <div><span class="metric-value" id="erVisits">{{ $opdData['erVisits'] ?? 0 }}</span></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- IPD Section -->
      <div class="row">
          <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="card soft-card metric-card">
                  <div class="card-header">Total Admissions</div>
                  <div class="card-body">
                      <div><span class="metric-value" id="totalAdmissions">{{ $ipdData['totalAdmissions'] ?? 0 }}</span></div>
                  </div>
              </div>
          </div>

          <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="card soft-card metric-card">
                  <div class="card-header">Current IP</div>
                  <div class="card-body">
                      <div><span class="metric-value" id="currentIpd">{{ $ipdData['currentIpd'] ?? 0 }}</span></div>
                  </div>
              </div>
          </div>

          <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="card soft-card metric-card">
                  <div class="card-header">Total Discharged</div>
                  <div class="card-body">
                      <div><span class="metric-value" id="totalDischarged">{{ $ipdData['totalDischarged'] ?? 0 }}</span></div>
                  </div>
              </div>
          </div>

          <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="card soft-card metric-card">
                  <div class="card-header">ER Conversion (OP, IP, OP to IP)%</div>
                  <div class="card-body">
                      <div><span class="metric-value">{{ $ipdData['erConversionPercentage'] ?? 0 }}%</span></div>
                  </div>
              </div>
          </div>
      </div>
      @php
          $avarageRevenueOpd = $avaragePatientRevenueOpd = $totalIPDPatientCount = $avaragePatientRevenueIpd = $avaragePatientRevenueOpd = 0;
          if ($opdData['opdHeadCount'] > 0) {
              $totalOPDPatient = $opdData['opdHeadCount'] ? $opdData['totalOPDPatient'][0]->patient_no_fk : 0;
              $totalIPDPatient = $ipdData['totalIpdPatient'] ? $ipdData['totalIpdPatient'][0]->patient_no_fk : 0;
              $avarageRevenueOpd =
                  $opdData['opdHeadCount'] > 0 ? $revenueData['totalRevenueOpd'] / $opdData['opdHeadCount'] : 0;

              $avaragePatientRevenueOpd = $totalOPDPatient > 0 ? $revenueData['totalRevenueOpd'] / $totalOPDPatient : 0;

              $avaragePatientRevenueIpd = $totalIPDPatient > 0 ? $revenueData['totalRevenueIpd'] / $totalIPDPatient : 0;
          }
      @endphp

      <div class="bg-success p-2" style="background-color: #97bba67a !important;">
          <!-- Revenue Section -->
          <div class="row">
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header text-center">
                          <h5 class="mb-0">OPD Revenue</h5>
                      </div>
                      <div class="card-body">
                          <!-- Revenue Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Revenue:</h6>
                              <h3 id="opdRevenueTotal" class="font-weight-bold text-success mb-0">
                                  {{ intval($revenueData['totalRevenueOpd']) ?? 0 }}
                              </h3>
                          </div>

                          <!-- Collection Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Collection:</h6>
                              <h3 id="totalCollectionOPD" class="font-weight-bold text-primary mb-0">
                                  {{ intval($collectionData['totalCollectionOpd']) ?? 0 }}
                              </h3>
                          </div>
                      </div>

                  </div>
              </div>




              {{-- <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">IP Revenue</div>
                      <div class="card-body">
                          <span class="metric-value"
                              id="ipdRevenueTotal">{{ intval($revenueData['totalRevenueIpd']) ?? 0 }}</span>

                      </div>
                  </div>
              </div> --}}


              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header text-center">
                          <h5 class="mb-0">IP Revenue</h5>
                      </div>
                      <div class="card-body">
                          <!-- Revenue Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Revenue:</h6>
                              <h3 id="ipdRevenueTotal" class="font-weight-bold text-success mb-0">
                                  {{ intval($revenueData['totalRevenueIpd']) ?? 0 }}
                              </h3>
                          </div>

                          <!-- Collection Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Collection:</h6>
                              <h3 id="ipdTotalCollection" class="font-weight-bold text-primary mb-0">
                                  {{ intval($collectionData['totalCollectionIpd']) ?? 0 }}
                              </h3>
                          </div>
                      </div>

                  </div>
              </div>


              {{-- <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card soft-card metric-card">
                    <div class="card-header text-center">

                        <div class="d-flex justify-content-between">
                            <h5 class="text-muted">Revenue</h5>
                            <h5 class="mb-0">IP Revenue</h5>
                            <h5 class="text-muted">Collection</h5>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h3 id="ipdRevenueTotal" class="font-weight-bold text-success">
                                    {{ intval($revenueData['totalRevenueIpd']) ?? 0 }}
                                </h3>
                            </div>
                            <div>
                                <h3 class="font-weight-bold text-primary">
                                    {{ intval($collectionData['totalCollectionIpd']) ?? 0 }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">Average OP Revenue</div>
                      <div class="card-body">
                          <span class="metric-value"
                              id="averageRevenueOpd">{{ intval($avarageRevenueOpd) ?? 0 }}</span>

                      </div>
                  </div>
              </div>

              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">OP Revenue per Patient</div>
                      <div class="card-body">
                          <span class="metric-value" id="averagePatientRevenueOpd">
                              {{ intval($avarageRevenueOpd) ?? 0 }}
                              {{-- {{ intval($avaragePatientRevenueOpd) ?? 0 }} --}}

                          </span>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Additional Revenue Metrics -->
          <div class="row">
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">Average IPD Revenue</div>
                      <div class="card-body">
                          <span class="metric-value">{{ intval($avaragePatientRevenueIpd) ?? 0 }}</span>
                      </div>
                  </div>
              </div>

              {{-- @php
                  $arpoB = 0;
                  $totalRevenueIpd = $revenueData['totalRevenueIpd'] ?? 0;
                  $totalOccupiedBedDays = $ipdData['totalOccupiedBedDays'] ?? 0;

                  if ($totalOccupiedBedDays > 0) {
                      $arpoB = round($totalRevenueIpd / $totalOccupiedBedDays, 2);
                  }
              @endphp

              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">ARPOB</div>
                      <div class="card-body">
                          <span class="metric-value" id="arpob">{{ $arpoB }}</span>
                      </div>
                  </div>
              </div> --}}


              @php
                  $alos = 0;
                  $totalIpdBedDays = $ipdData['totalIpdBedDays'] ?? 0;
                  $totalDischargedPatients = $ipdData['totalDischarged'] ?? 0;
                  if ($totalDischargedPatients > 0) {
                      $alos = round($totalIpdBedDays / $totalDischargedPatients, 2);
                  }
              @endphp

              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">ALOS (Avg Length of Stay)</div>
                      <div class="card-body">
                          <span class="metric-value" id="alos">{{ $alos }} days</span>
                      </div>
                  </div>
              </div>


              {{-- <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header">Total Pharmacy Revenue</div>
                      <div class="card-body">
                          <span class="metric-value">{{ intval($revenueData['totalRevenuePhr']) ?? 0 }}</span>

                      </div>
                  </div>
              </div> --}}

              {{-- <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header text-center">

                          <div class="d-flex justify-content-between">
                              <h5 class="text-muted">Revenue</h5>
                              <h5 class="mb-0">Pharmacy Revenue</h5>
                              <h5 class="text-muted">Collection</h5>
                          </div>
                      </div>
                      <div class="card-body text-center">
                          <div class="d-flex justify-content-between align-items-center mb-3">
                              <div>
                                  <h3 id="ipdRevenueTotal" class="font-weight-bold text-success">
                                      {{ intval($revenueData['totalRevenuePhr']) ?? 0 }}
                                  </h3>
                              </div>
                              <div>
                                  <h3 class="font-weight-bold text-primary">
                                      {{ intval($collectionData['totalCollectionPhr']) ?? 0 }}
                                  </h3>
                              </div>
                          </div>
                      </div>
                  </div>
              </div> --}}
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header text-center">
                          <h5 class="mb-0">Total Pharmacy Revenue</h5>
                      </div>
                      <div class="card-body">
                          <!-- Revenue Section -->
                          <!-- Revenue Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Revenue:</h6>
                              <h3 id="ipdRevenuePhr" class="font-weight-bold text-success mb-0">
                                  {{ round($revenueData['totalRevenuePhr'] ?? 0) }}
                              </h3>
                          </div>

                          <!-- Collection Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Collection:</h6>
                              <h3 id="phrTotalCollection" class="font-weight-bold text-primary mb-0">
                                  {{ round($collectionData['totalCollectionPhr'] ?? 0) }}
                              </h3>
                          </div>


                      </div>
                  </div>
              </div>

             <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="card soft-card metric-card">
                      <div class="card-header text-center">
                          <h5 class="mb-0">Total Revenue</h5>
                      </div>
                      <div class="card-body">
                          <!-- Revenue Section -->
                          <!-- Revenue Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Revenue:</h6>
                              <h3 id="totalRevenue" class="font-weight-bold text-success mb-0">
                                  {{ round($revenueData['totalRevenue'] ?? 0) }}
                              </h3>
                          </div>

                          <!-- Collection Section -->
                          <div class="d-flex justify-content-center align-items-center">
                              <h6 class="text-muted mb-0 me-2">Collection:</h6>
                              <h3 id="totalCollection" class="font-weight-bold text-primary mb-0">
                                  {{ round($collectionData['totalCollection'] ?? 0) }}
                              </h3>
                          </div>


                      </div>
                  </div>
              </div>
          </div>


          <!-- Graph Section -->
          <div class="row">
              <!-- Graphs Section -->
              <div class="col-md-6">
                  <div class="card graph-card soft-card">
                      <div class="card-header">OPD Metrics</div>
                      <div class="card-body">
                          <canvas id="opdMetricsChart"></canvas>
                      </div>
                  </div>
              </div>

              <div class="col-md-6">
                  <div class="card graph-card soft-card">
                      <div class="card-header">IPD Metrics</div>
                      <div class="card-body">
                          <canvas id="ipdMetricsChart"></canvas>
                      </div>
                  </div>
              </div>
          </div>
          <footer class="text-center py-3">
              <p>&copy; 2025 Nextgen Innovation Ltd.</p>
          </footer>



      </div>

      <script type="application/javascript" src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js') }}"></script>
      <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
      <!--INTERNAL Flot Charts js-->

      <!-- Bootstrap JS and dependencies -->
      {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> --}}
      {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js"></script> --}}

      <!-- Chart.js Script -->
      <script>
          // SideBar Collapse
          $("body").addClass("sidebar-collapse");
          $("#sidebar-left").addClass("active");
          $("#content").addClass("active");
          $(function() {
              $('.date_picker').datepicker({
                  todayHighlight: true,
                  clearBtn: true,
                  autoclose: true,
                  endDate: '+0d',
                  'format': 'dd/mm/yyyy'
              });
          });
          // $(".AutoScroll").scroller();
          // OPD Metrics Chart
          var opdData = @json($opdData); // Get the OPD data passed from the controller

          var opdMetricsChart = new Chart(document.getElementById('opdMetricsChart').getContext('2d'), {
              type: 'bar',
              data: {
                  labels: ['New Registration', 'OPD Consultations', 'OPD Head Count', 'ER Visits'],
                  datasets: [{
                      label: 'OPD Metrics',
                      data: [
                          opdData.newRegistration,
                          opdData.opdConsultations,
                          opdData.opdHeadCount,
                          opdData.erVisits
                      ],
                      backgroundColor: ['#4e8be6', '#28a745', '#ffc107', '#dc3545'],
                      borderColor: ['#4e8be6', '#28a745', '#ffc107', '#dc3545'],
                      borderWidth: 1
                  }]
              },
              options: {
                  responsive: true,
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });

          // IPD Metrics Chart
          var ipdData = @json($ipdData); // Get the IPD data passed from the controller

          var ipdMetricsChart = new Chart(document.getElementById('ipdMetricsChart').getContext('2d'), {
              type: 'bar',
              data: {
                  labels: ['Total Admissions', 'Current IPD', 'Total Discharged', 'ER Conversion (%)'],
                  datasets: [{
                      label: 'IPD Metrics',
                      data: [
                          ipdData.totalAdmissions,
                          ipdData.currentIpd,
                          ipdData.totalDischarged,
                          ipdData.erConversionPercentage
                      ],
                      backgroundColor: ['#007bff', '#17a2b8', '#ffc107', '#28a745'],
                      borderColor: ['#007bff', '#17a2b8', '#ffc107', '#28a745'],
                      borderWidth: 1
                  }]
              },
              options: {
                  responsive: true,
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });

          // Handle the Search button click
          $('#dashboard_search').on('click', function() {
              var fromDate = $('#from-date').val();
              var toDate = $('#to-date').val();

              // Validate if both dates are provided
              if (fromDate && toDate) {
                  // Send AJAX request
                  $.ajax({
                      url: "{{ route('v3.management-dashboard-search') }}", // Define route for AJAX search
                      method: "POST",
                      data: {
                          from_date: fromDate,
                          to_date: toDate
                      },
                      success: function(response) {
                          console.log(response)
                          if (response.success) {
                              // Update OPD Data
                              $('#newRegistration').html(response.opdData.newRegistration);
                              $('#opdConsultations').html(response.opdData.opdConsultations);
                              $('#opdHeadCount').html(response.opdData.opdHeadCount);
                              $('#erVisits').html(response.opdData.erVisits);

                              // Update IPD Data
                              $('#totalAdmissions').html(response.ipdData.totalAdmissions);
                              $('#currentIpd').html(response.ipdData.currentIpd);
                              $('#totalDischarged').html(response.ipdData.totalDischarged);
                              $('#erConversionPercentage').html(response.ipdData.erConversionPercentage);

                              // Update Revenue and Averages from Calculated Data
                              $('#opdRevenueTotal').html(parseInt(response.revenueData.totalRevenueOpd));
                              $('#ipdRevenueTotal').html(parseInt(response.revenueData.totalRevenueIpd));
                              $('#totalCollectionOPD').html(parseInt(response.collectionData
                                  .totalCollectionOpd));
                              $('#ipdTotalCollection').html(parseInt(response.collectionData
                                  .totalCollectionIpd));
                              $('#phrTotalCollection').html(Math.round(response.collectionData.totalCollectionPhr));
                              $('#totalCollection').html(Math.round(response.collectionData.totalCollection));

                              $('#averageRevenueOpd').html(response.averageRevenueOpd);
                             $('#ipdRevenuePhr').html(Math.round(response.revenueData.totalRevenuePhr));
                             $('#totalRevenue').html(Math.round(response.revenueData.totalRevenue));

                              $('#averagePatientRevenueOpd').html(response.averagePatientRevenueOpd);
                              $('#averagePatientRevenueIpd').html(response.averagePatientRevenueIpd);
                              $('#arpob').html(response.arpoB);
                              $('#alos').html(response.alos);

                          } else {
                              alert('No data found for the selected date range.');
                          }
                      },
                      error: function(xhr, status, error) {
                          console.error("Error fetching data: " + error);
                          alert("An error occurred while fetching the data.");
                      }
                  });
              } else {
                  alert("Please select both From and To dates.");
              }
          });
      </script>
