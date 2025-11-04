<section id="ot_booking">
    <style>
        /* Layout */
        .ot-container {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }

        #patient-list,
        #patient-detail {
            flex: 1;
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            max-height: 80vh;
            overflow-y: auto;
        }

        /* Patient list item */
        .patient-item {
            display: flex;
            align-items: center;
            background: #fff;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 6px;
            transition: transform .1s, box-shadow .2s;
            cursor: pointer;
        }

        .patient-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .patient-photo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #007bff;
            margin-right: 16px;
        }

        .patient-info h6 {
            margin: 0 0 4px;
        }

        .patient-info small {
            color: #6c757d;
        }

        /* Detail panel */
        #patient-detail img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #007bff;
            margin-bottom: 16px;
        }

        #patient-detail h4 {
            margin-top: 0;
        }

        #patient-detail p {
            margin: 8px 0;
        }

        .btn-book {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

        .btn-book:hover {
            background-color: #0056b3;
        }
    </style>

    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm p-3">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">OT Slot Book</h5>
                    <small>Patient / Today's Patients</small>
                </div>
                <!-- Optional action button -->
                <div id="top-action">
                    {{-- <button class="btn btn-outline-primary btn-md open-modal" data-modal="common-modal-sm"
                        data-action="{{ route('bed.create') }}" data-title="Create New Bed">
                        <i class="fa fa-plus"></i> Create New Bed
                    </button> --}}
                </div>
            </div>
        </div>

        <div class="ot-container">
            <!-- Patient List -->
            <div id="patient-list">
                <!-- dynamically loaded list items -->
                <div class="patient-item" data-id="1">
                    <img src="https://via.placeholder.com/60" class="patient-photo" alt="John Doe">
                    <div class="patient-info">
                        <h6>John Doe</h6>
                        <small>Dept: Surgery • 2025‑07‑14</small>
                    </div>
                </div>
                <!-- repeat for each patient -->
            </div>

            <!-- Patient Detail -->
            <div id="patient-detail">
                <em>Select a patient to view details</em>
            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function() {
        // Fetch today's patients on page load
        fetchPatients();

        // Event listener for patient selection
        $(document).on('click', '.patient-item', function() {
            const req_id = $(this).data('id');
            fetchPatientDetail(req_id);
        });

        // Function to fetch and display patients
        function fetchPatients() {
            $.ajax({
                url: "{{ route('todays-patient') }}",
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const patientList = data.data;
                    let html = '<ul class="list-group patient-list">';

                    patientList.forEach(patient => {
                        html += `
                <li class="list-group-item patient-item list-group-item-action mb-2" data-id="${patient.reff_anes_dept_no_pk}">
                    <div class="d-flex align-items-center">
                        <img src="${patient.photo_url}" alt="${patient.patient_name}" class="patient-photo rounded-circle mr-3" />
                        <div class="flex-fill">
                            <h6 class="mb-1 font-weight-bold">${patient.patient_name}</h6>
                            <p class="mb-1 text-muted small">
                                <strong>Dept:</strong> ${patient.req_dept_name} • 
                                <strong>Date:</strong> ${patient.requisition_date}
                            </p>
                        </div>
                        </div>
                </li>
                `;
                    });

                    html += '</ul>';
                    $('#patient-list').html(html);
                },
                error: function(error) {
                    console.error('Error fetching patients:', error);
                    $('#patient-list').html(
                        '<div class="alert alert-danger">Failed to load patient data.</div>');
                }
            });
        }


        function fetchPatientDetail(id) {
            const patientUrlTpl = "{{ route('ot.show-patient-details', ':id') }}";
            const url = patientUrlTpl.replace(':id', id);

            // Helper functions
            function cleanDate(str) {
                return (!str || str === '01/01/1970') ? 'Not available' : str;
            }

            function clean(val, placeholder = 'Not available') {
                return (val === null || val === undefined || val === '') ? placeholder : val;
            }

            $.ajax({
                url,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    const p = data.data;

                    const html = `
  <div class="card shadow-sm border-0 rounded-lg overflow-hidden">
    <div class="px-4 py-3 text-white" style="background: linear-gradient(135deg, #4e54c8, #8f94fb);">
      <div class="d-flex align-items-center">
        <img src="${clean(p.photo_url, 'default-photo.jpg')}" alt="${clean(p.patient_name, 'N/A')}"
             class="rounded-circle border border-white me-3"
             style="width: 90px; height: 90px; object-fit: cover;">
        <div>
          <h4 class="mb-1">${clean(p.patient_name, 'Patient name not available')}</h4>
          <small>${clean(p.gender_txt, '–')}, Age ${clean(p.age, '–')}</small>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row mb-2">
        <div class="col-sm-6"><strong>Admission:</strong><br>${cleanDate(p.admission_date)}</div>
        <div class="col-sm-6"><strong>Ward / Bed:</strong><br>${clean(p.ward_name)} / ${clean(p.bed_name)}</div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-6"><strong>Admitted Dept:</strong><br>${clean(p.admitted_department)}</div>
        <div class="col-sm-6"><strong>Reff Dept:</strong><br>${clean(p.req_dept_name)}</div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-6"><strong>Requisition:</strong><br>${cleanDate(p.reff_date)}</div>
        <div class="col-sm-6"><strong>Req Given:</strong><br>${cleanDate(p.req_given_date)}</div>
      </div>
      <p><strong>Diagnosis:</strong> ${clean(p.diagnosis, 'Not provided')}</p>
      <p><strong>Purpose/Remarks:</strong> ${clean(p.purpose_off_reff, 'Not provided')}</p>
      <p><strong>Urgency:</strong> ${clean(p.urgency_details, 'Not provided')}</p>
      <p><strong>Surgeon:</strong> ${clean(p.surgen_name)} | <strong>Nurse:</strong> ${clean(p.nurse_name)}</p>
    </div>
    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
      <span class="badge bg-primary px-3 py-2">Duration: ${clean(p.estimated_duration_surge)}</span>
      <button class="btn text-white px-4"
              data-req-id="${p.reff_anes_dept_no_pk || ''}"
              data-pres-id="${p.prescription_no_fk || ''}"
              onclick="bookSlotForOT(this)"
              style="background: linear-gradient(90deg, #8f94fb, #4e54c8);">
        Book Slot
      </button>
    </div>
  </div>`;

                    $('#patient-detail').html(html);
                },
                error: function(err) {
                    console.error('Error fetching patient details:', err);
                    $('#patient-detail').html(
                        `<div class="alert alert-danger">Unable to load patient details.</div>`);
                }
            });
        }
    });

    function bookSlotForOT(thisElement) {
        const path = window.location.pathname.replace(/\/$/, '');
        const slotId = path.substring(path.lastIndexOf('/') + 1);
        const reqId = $(thisElement).data('req-id');
        const presId = $(thisElement).data('pres-id');

        if (!slotId || !reqId) {
            alert('Missing required identifiers.');
            return;
        }

        const urlTemplate = "{{ route('ot.slot-book-store', ':id') }}";
        const url = urlTemplate.replace(':id', slotId);

        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    reqId: reqId,
                    slotId: slotId,
                    presId: presId,
                },
            })
            .done(data => {
                alert(data.message || 'Slot booked successfully.');
                window.history.back();
            })
            .fail((jqXHR, textStatus, errorThrown) => {
                console.error('Booking error:', textStatus, errorThrown);
                alert('Failed to book slot. Please try again.');
            });
    }
</script>
