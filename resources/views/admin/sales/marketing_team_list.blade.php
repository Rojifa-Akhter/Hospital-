<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<section>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                Marketing Members Information
            </h5>
        </div>

        <div class="card-body">
            <form action="" id="searchForm" method="post" target="_blank">
                @csrf
                <div class="form-row justify-content-center mb-3">
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="primary_doctor" class="col-form-label col-form-label-sm">Referral Name</label>
                            <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                name="primary_doctor" maxlength="50" placeholder="Referral Name" />
                            <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                            <div><strong>
                                    <p id="autocomplete_data"></p>
                                </strong></div>
                        </div>
                    </div> --}}

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ref_type" class="col-form-label col-form-label-sm">Referral Type</label>
                            <select class="form-control font_size_12 m-auto" id="ref_type" name="ref_type"
                                onchange="submitForm()">
                                <option value="">Select Referral Type</option>
                                @if (isset($refTypes))
                                    @foreach ($refTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Export Buttons -->
            <div class="mb-3">
                <button id="exportExcel" class="btn btn-success btn-sm">Export to Excel</button>
                {{-- <button id="exportPDF" class="btn btn-danger btn-sm">Export to PDF</button> --}}
            </div>

            <!-- Table for displaying teams -->
            <div class="table-responsive">
                <h3>{{ !empty($agent_name) ? $agent_name : 'No Agent Selected' }}</h3>

                <table id="myTable" class="table table-bordered table-hover table-striped data-table">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-center" scope="col">Sl#</th>
                            <th class="text-center" scope="col">Referral Type</th>
                            <th class="text-center" scope="col">Referral Code</th>
                            <th class="text-center" scope="col">Full Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($members as $index => $member)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $member->lookupdata_name }}</td>
                                <td class="text-center">{{ $member->person_code }}</td>
                                <td class="text-center"><strong>{{ $member->salutation }}
                                        {{ $member->full_name }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>

            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.2/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    // Function to automatically submit the form when doctor_id or ref_type changes
    function submitForm() {
        // Collect form data
        var doctor_id = $('#doctor_id').val();
        var ref_type = $('#ref_type').val();

        console.log(doctor_id)

        // Check if either doctor_id or ref_type has a value before sending the AJAX request
        if (doctor_id !== "" || ref_type !== "") {
            fetchMembers(doctor_id, ref_type);
        }
    }

    // AJAX function to fetch marketing members based on doctor_id and ref_type
    function fetchMembers(doctor_id, ref_type) {
        $.ajax({
            url: '{{ route('agent-members-search') }}', // Create a route in your routes/web.php for this
            type: 'GET',
            data: {
                doctor_id: doctor_id,
                ref_type: ref_type
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(response) {
                // Clear existing table data
                $('#myTable tbody').empty();

                // Loop through the response data and populate the table
                if (response.members && response.members.length > 0) {
                    response.members.forEach(function(member, index) {
                        $('#myTable tbody').append(
                            `<tr>
                                <td class="text-center">${index + 1}</td>
                                <td class="text-center">${member.lookupdata_name}</td>
                                <td class="text-center">${member.person_code}</td>
                                <td class="text-center"><strong>${member.salutation} ${member.full_name}</strong></td>
                            </tr>`
                        );
                    });
                } else {
                    $('#myTable tbody').append(
                        `<tr><td colspan="4" class="text-center">No members found.</td></tr>`
                    );
                }
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    // Initialize the autocomplete for primary_doctor
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    // Event handler for primary_doctor input change to trigger form submission
    $('#primary_doctor').on('input', function() {
        if ($('#doctor_id').val() !== "") {
            submitForm();
        }
    });

    // Export to Excel Function
    $('#exportExcel').on('click', function() {
        let table = document.getElementById('myTable');
        let wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(wb, "marketing_members.xlsx");
    });

    // Export to PDF Function
    $('#exportPDF').on('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Get table data to be printed in PDF
        let table = document.getElementById('myTable');
        let rows = [];
        for (let i = 1; i < table.rows.length; i++) {
            let row = [];
            for (let j = 0; j < table.rows[i].cells.length; j++) {
                row.push(table.rows[i].cells[j].innerText);
            }
            rows.push(row);
        }

        // Set PDF header
        doc.setFontSize(12);
        doc.text("Marketing Members Information", 14, 10);
        doc.autoTable({
            head: [['Sl#', 'Referral Type', 'Referral Code', 'Full Name']],
            body: rows,
            startY: 20,
            theme: 'grid'
        });

        // Save PDF
        doc.save("marketing_members.pdf");
    });
</script>
