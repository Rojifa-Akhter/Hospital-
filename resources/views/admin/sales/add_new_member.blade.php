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
                    <h5 class="mt-2 mb-0">Add New Member</h5>
                    <small>Team Setup / Add New Member</small>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body mt-2">
                <div class="container">
                    <label for="team_name">Team Name:</label>
                    <input type="text" id="team_name" name="team_name" value="{{ $team_member->team_name }}" required>
                    <input type="hidden" value="{{ $team_member->team_no_pk }}" name="team_id">

                    <form id="addMemberForm">
                        <label for="employee-list">Member Name:</label>
                        <select id="employee-list" name="employee-list" required>
                            <option value="" disabled selected>Select an employee</option>
                            @if (!empty($teams))
                                @foreach ($teams as $employee)
                                    <option value="{{ $employee->person_no_pk }}">{{ $employee->full_name }}</option>
                                @endforeach
                            @endif
                        </select>

                        <label for="lead">Lead:</label>
                        <select id="lead" name="lead" required>
                            <option value="N">No</option>
                            <option value="Y">Yes</option>
                        </select>

                        <label for="marketing-area">Marketing Areas:</label>
                        <select id="marketing-area" name="marketing-area[]" multiple required>
                            @if (!empty($areas))
                                @foreach ($areas as $area)
                                    <option value="{{ $area->area_no_pk }}">{{ $area->area_code }}</option>
                                @endforeach
                            @endif
                        </select>
                    </form>

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

<script type="application/javascript">
    $(document).ready(function() {
        // Initialize Select2 for select elements
        $('#employee-list').select2();
        $('#marketing-area').select2();

        // Handle Add Member Form submission
        $('#addMemberForm').on('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting normally

            // Client-side validation
            if (!$('#employee-list').val()) {
                alert('Please select an employee');
                return;
            }

            if (!$('#marketing-area').val()) {
                alert('Please select at least one marketing area');
                return;
            }

            // Gather form data
            var formData = {
                _token: '{{ csrf_token() }}',
                teamName: $('#team_name').val(),
                employeeId: $('#employee-list').val(),
                lead: $('#lead').val(),
                areas: $('#marketing-area').val()
            };

            // Send AJAX request
            $.ajax({
                url: '{{ route("add-new-member-store") }}', // Add appropriate route URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Dynamically update the page with the new member
                        addMemberToList(response.member);
                        alert('New member added successfully!');
                    } else {
                        alert('Failed to add member.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert('An error occurred while adding the member.');
                }
            });
        });
    });

    // Function to dynamically add a new member to the list
    function addMemberToList(member) {
        var memberHtml = `
            <div class="member">
                <strong>${member.full_name}</strong>
                <p><b>Lead:</b> ${member.is_lead === 'Y' ? 'Yes' : 'No'}</p>
                <p><b>Areas:</b> ${member.area_codes}</p>
                <button class="btn btn-sm btn-danger" onclick="deleteMember(${member.person_no_pk})">Delete</button>
            </div>
        `;
        $('#member-list').append(memberHtml);
    }

    // Save team function (you can implement the save functionality later)
    function saveTeam() {
        
        var formData = {
            _token: '{{ csrf_token() }}',
            teamName: $('#team_name').val(),
            areas: $('#marketing-area').val(),
            lead: $('#lead').val(),
            memberId: $('#employee-list').val(),
            teamId: $('input[name="team_id"]').val()
        };

        $.ajax({
            url: '{{ route("add-new-member-store") }}', // Use appropriate route for saving the team
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    alert('Team saved successfully!');
                } else {
                    alert('Failed to save team.');
                }
            }
        });
    }

    // Exit function
    function exitTeam() {
        // Optionally implement exit logic (e.g., navigate to another page)
        window.location.href = '/teams'; // Redirect to team list page
    }
</script>
