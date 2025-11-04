<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Sales Team List</h5>
                <small>Settings / Sales Team / Sales Team List</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>
                    Sales Team List
                    <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-sm"
                        data-action="{{ route('create-marketing-setup') }}" data-title="Create Sales Team">Create Sales
                        Team</button>
                </h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <!-- Table for displaying teams -->
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Employee Name</th>
                                    <th class="text-center" scope="col">Area</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vTeams as $teamKey => $members)
                                    <!-- Split $teamKey by ~ to get team name and team ID -->
                                    @php
                                        $teamParts = explode('~', $teamKey);
                                        $teamName = $teamParts[0];
                                        $teamNo = $teamParts[1];
                                    @endphp

                                    <!-- Team Row with Add New Member Button -->
                                    <tr>
                                        <td>{{ $loop->iteration }}</td> <!-- Sl# for the team -->
                                        <td><strong>{{ $teamName }}</strong> <!-- Team Name -->
                                            <button class="btn btn-sm btn-success open-modal"
                                                data-modal="common-modal-sm"
                                                data-action="{{ route('add-new-member-setup', $teamNo) }}"
                                                data-title="Add New Member">Add New Member</button>
                                        </td>
                                        <td></td> <!-- Empty column for spacing -->
                                    </tr>
                                    <!-- Display Member Rows for the current team -->
                                    @foreach ($members as $member)
                                        <tr>
                                            <td></td> <!-- Leave Sl# empty for members -->
                                            <td>{{ $member['full_name'] ?? 'N/A' }}</td> <!-- Employee Name -->
                                            <td>{{ implode(', ', $member['area_codes']) ?? 'N/A' }}</td>
                                            <!-- Area Codes -->
                                            <td>
                                                @if ($member['status'] == 0)
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="activeMemberFromTeam({{ $member['person_no_pk'] }})">Inactive</button>
                                                @else
                                                    <button class="btn btn-sm btn-success"
                                                        onclick="inactiveMemberFromTeam({{ $member['person_no_pk'] }})">Active</button>
                                                @endif
                                                <!-- Delete Member Button -->

                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding a New Member -->
    <div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberModalLabel">Add New Member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add New Member Form -->
                    <form id="addMemberForm">
                        <div class="form-group">
                            <label for="employee-name">Employee Name</label>
                            <input type="text" class="form-control" id="employee-name" name="employee-name" required>
                        </div>
                        <div class="form-group">
                            <label for="area-codes">Area Codes</label>
                            <select id="area-codes" name="area-codes[]" class="form-control" multiple required>
                                <!-- Populate areas dynamically here -->
                                <option value="Badda">Badda</option>
                                <option value="Uttara">Uttara</option>
                                <option value="Gulshan">Gulshan</option>
                                <!-- Add your area options dynamically -->
                            </select>
                        </div>
                        <input type="hidden" id="team-name" name="team-name">
                        <button type="submit" class="btn btn-primary">Add Member</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable with custom options
        $('#datatable').DataTable({
            "paging": true, // Enable pagination
            "lengthChange": false, // Disable changing number of rows per page
            "searching": true, // Enable searching
            "ordering": true, // Enable column sorting
            "info": true, // Display info (e.g., "Showing 1 to 10 of 50 entries")
            "autoWidth": false, // Disable auto column width
            "responsive": true // Enable responsive table design
        });
    });

    function inactiveMemberFromTeam(teamId) {
        // Ask for confirmation before deleting
        if (confirm('Are you sure you want to Inactive from team?')) {
            $.ajax({
                url: '{{ route('team.delete', '') }}/' + teamId, // Ensure this matches your route
                method: 'POST', // Use POST method for sending data
                data: {
                    _method: 'DELETE', // Laravel specific hack to send DELETE requests via POST
                    _token: '{{ csrf_token() }}', // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert('Inactive Member successfully!');

                        // Refresh the page to reflect the changes
                        location.reload();
                    } else {
                        // Show failure message
                        alert('Failed to delete the team. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    alert('An error occurred: ' + error);
                }
            });
        }
    }

    function activeMemberFromTeam(teamId) {
        // Ask for confirmation before deleting
        if (confirm('Are you sure you want to active this member?')) {
            $.ajax({
                url: '{{ route('team.member-active', '') }}/' + teamId, // Ensure this matches your route
                method: 'POST', // Use POST method for sending data
                data: {
                    _method: 'DELETE', // Laravel specific hack to send DELETE requests via POST
                    _token: '{{ csrf_token() }}', // CSRF token for security
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        alert('Active Member successfully!');

                        // Refresh the page to reflect the changes
                        location.reload();
                    } else {
                        // Show failure message
                        alert('Failed to delete the team. Please try again.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    alert('An error occurred: ' + error);
                }
            });
        }
    }


    // // Open Modal for Adding New Member
    // function openAddMemberModal(teamName) {
    //     // Set the team name in the hidden field so we know which team the member belongs to
    //     document.getElementById('team-name').value = teamName;
    //     $('#addMemberModal').modal('show'); // Show the modal
    // }

    // Handle Add New Member Form Submission
    $('#addMemberForm').on('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // Get the form data
        var teamName = $('#team-name').val();
        var employeeName = $('#employee-name').val();
        var areaCodes = $('#area-codes').val(); // Get selected areas

        // Perform AJAX request to add the new member
        $.ajax({
            url: '{{ route('team.delete', 'dgsdf') }}/', // Your server endpoint to handle this
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // CSRF token for Laravel
                teamName: teamName,
                employeeName: employeeName,
                areaCodes: areaCodes
            },
            success: function(response) {
                if (response.success) {
                    alert('Member added successfully!');
                    $('#addMemberModal').modal('hide');
                    location.reload(); // Refresh the page to show the new member
                } else {
                    alert('Error adding member');
                }
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
</script>
