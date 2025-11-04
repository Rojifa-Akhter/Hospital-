<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    .container {
        max-width: 700px;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        margin: auto;
    }

    h1 {
        font-size: 24px;
        text-align: center;
        color: #4CAF50;
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }

    input[type="text"],
    select {
        width: 100%;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        transition: border-color 0.3s;
        font-size: 14px;
    }

    input[type="text"]:focus,
    select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    .select2-container {
        width: 100% !important;
    }

    button {
        padding: 12px 20px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #45a049;
    }

    .member {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 15px;
        font-size: 14px;
    }

    .member strong {
        display: block;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .action-buttons button {
        width: 48%;
    }

    .save-exit {
        display: flex;
        gap: 15px;
    }

    .card-header {
        padding: 20px;
        background-color: #f4f7fc;
        border-radius: 6px 6px 0 0;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card-header h5 {
        font-size: 18px;
        color: #333;
    }

</style>

<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Create Sales Team</h5>
                    <small>Team Setup / Create Sales Team</small>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body mt-2">
                <div class="container">
                    <label for="team_name">Team Name:</label>
                    <input type="text" id="team_name" name="team_name" required>

                    <form id="team-form">
                        <label for="employee-list">Member Name:</label>
                        <select id="employee-list" name="employee-list">
                            <option value="" disabled selected>Select an employee</option>
                            @if (!empty($teams))
                                @foreach ($teams as $employee)
                                    <option value="{{ $employee->person_no_pk }}">{{ $employee->full_name }}</option>
                                @endforeach
                            @endif
                        </select>

                        <label for="lead">Lead:</label>
                        <select id="lead" name="lead">
                            <option value="N">No</option>
                            <option value="Y">Yes</option>
                        </select>

                        <label for="marketing-area">Marketing Areas:</label>
                        <select id="marketing-area" name="marketing-area" multiple>
                            @if (!empty($areas))
                                @foreach ($areas as $area)
                                    <option value="{{ $area->area_no_pk }}">{{ $area->area_code }}</option>
                                @endforeach
                            @endif
                        </select>

                        <div class="button-group">
                            <button type="button" class="add-member" onclick="addMember()">Add Member</button>
                        </div>
                    </form>

                    <div id="member-list"></div>

                    <div class="action-buttons">
                        <div class="save-exit">
                            <button type="button" class="btn btn-primary" onclick="saveTeam()">Save</button>
                            <button type="button" class="btn btn-danger" onclick="exitTeam()">Exit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for the marketing area
        $('#marketing-area').select2({
            placeholder: "Select marketing areas",
            allowClear: true
        });

        // Initialize Select2 for the employee list (Searchable)
        $('#employee-list').select2({
            placeholder: "Search and select an employee",
            allowClear: true
        });

        // Create a mapping of area IDs to area codes
        window.areaMapping = {}; // Ensure areaMapping is accessible globally
        @if (!empty($areas))
            @foreach ($areas as $area)
                areaMapping['{{ $area->area_no_pk }}'] = '{{ $area->area_code }}';
            @endforeach
        @endif
    });

    const addedMembers = []; // To keep track of added members

    function addMember() {
        const employeeList = document.getElementById('employee-list');
        const memberId = employeeList.value; // Get selected employee ID
        const memberName = employeeList.options[employeeList.selectedIndex].text; // Get selected employee name
        const leadStatus = document.getElementById('lead').value;
        const selectedAreas = $('#marketing-area').val();

        if (memberId && selectedAreas.length > 0) {
            // Check if the member is already added
            if (addedMembers.find(member => member.id === memberId)) {
                alert("This member has already been added.");
                return;
            }

            // Create an array to hold the selected area names
            const areaNames = selectedAreas.map(areaId => areaMapping[areaId]);

            // Add the member details to the array
            addedMembers.push({
                id: memberId,
                name: memberName,
                lead: leadStatus,
                areas: selectedAreas
            });

            // Create and display the member info
            const memberList = document.getElementById('member-list');
            const memberDiv = document.createElement('div');
            memberDiv.className = 'member';
            memberDiv.innerHTML = `
                    <strong>Member Name:</strong> ${memberName}
                    <strong>Lead:</strong> ${leadStatus}
                    <strong>Marketing Areas:</strong> ${areaNames.join(', ')}
                `;
            memberList.appendChild(memberDiv);

            // Reset the selections
            employeeList.selectedIndex = 0;
            document.getElementById('lead').value = 'N';
            $('#marketing-area').val(null).trigger('change'); // Deselect all options in Select2
        } else {
            alert("Please select an employee and choose at least one marketing area.");
        }
    }

    function saveTeam() {
        const teamName = $('#team_name').val();
        console.log('team name: '+ $('#team_name').val());

        if (addedMembers.length === 0) {
            alert("Please add at least one member before saving.");
            return;
        }

        $.ajax({
            url: '{{ route('marketing-setup-store') }}', // Laravel route
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Laravel CSRF token
                teamName: teamName,
                members: addedMembers
            },
            success: function(response) {
                alert("Team saved successfully!");
                // Clear the added members and reset the form
                addedMembers.length = 0;
                $('#member-list').empty();
                $('#team_name').val(''); // Clear the team name
                $('#employee-list').val(null).trigger('change'); // Deselect employee
                document.getElementById('lead').value = 'N';
                $('#marketing-area').val(null).trigger('change'); // Deselect all marketing areas
            },
            error: function(xhr, status, error) {
                alert("Error saving team: " + error);
            }
        });
    }

    function exitTeam() {
        // Logic to exit, such as redirecting or closing a modal
        window.location.href = '{{ route('team.setup') }}'; // Adjust with your exit route
    }
</script>
