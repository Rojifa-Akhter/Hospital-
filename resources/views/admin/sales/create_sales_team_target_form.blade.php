<!-- Bootstrap Datepicker CSS -->
<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<form action="{{ route('marketing-setup-target-store') }}" method="post" id="lookup-create">
    @csrf
    <input type="hidden" name="id" value="{{ optional($target)->achivement_no_pk }}">

    <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-sm">Marketing Team <span
                class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control select2" id="marketing_team" name="marketing_team" required>
                <option value="">Select Marketing Team</option>
                @foreach ($teams as $val)
                    <option value="{{ $val->team_no_pk }}"
                        {{ optional($target)->team_no_fk == $val->team_no_pk ? 'selected' : '' }}>
                        {{ ucwords(strtolower($val->team_name)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <label class="col-sm-2 col-form-label col-form-label-sm">Member Name <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <select class="form-control select2" id="member_name" name="member_name" required>
                <option value="">Select Member Name</option>
                @foreach ($member_list as $val)
                    <option value="{{ $val->person_no_pk }}"
                        {{ optional($target)->sales_person_no_fk == $val->person_no_pk ? 'selected' : '' }}>
                        {{ ucwords(strtolower($val->full_name)) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-sm">Month/Year <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="text" class="form-control" id="date_picker" name="date_picker" required
                value="{{ isset($target) ? $target->target_month . '/' . $target->target_year : '' }}"
                placeholder="Select Month/Year">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-sm">Target Patient <span
                class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="target_patient" name="target_patient" required
                placeholder="Enter Target Patient"
                value="{{ old('target_patient', optional($target)->total_ptn_target) }}">
        </div>

        <label class="col-sm-2 col-form-label col-form-label-sm">Target Sales Amount<span
                class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="target_sales" name="target_sales" required
                placeholder="Enter Target Sales" value="{{ old('target_sales', optional($target)->target_amnt) }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-sm">OPD Patient <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="opd_patient" name="opd_patient" required
                placeholder="Enter OPD Patient"
                value="{{ old('opd_patient', optional($target)->achieved_opd_ptn_qty) }}">
        </div>

        <label class="col-sm-2 col-form-label col-form-label-sm">IPD Patient <span class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="ipd_patient" name="ipd_patient" required
                placeholder="Enter IPD Patient"
                value="{{ old('ipd_patient', optional($target)->achieved_ipd_ptn_qty) }}">
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label col-form-label-sm">OPD Sales Amount<span
                class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="opd_sales" name="opd_sales" required
                placeholder="Enter OPD Sales"
                value="{{ old('opd_sales', optional($target)->achieved_opd_target_amnt) }}">
        </div>

        <label class="col-sm-2 col-form-label col-form-label-sm">IPD Sales Amount<span
                class="text-danger">*</span></label>
        <div class="col-sm-4">
            <input type="number" class="form-control" id="ipd_sales" name="ipd_sales" required
                placeholder="Enter IPD Sales"
                value="{{ old('ipd_sales', optional($target)->achieved_ipd_target_amnt) }}">
        </div>
    </div>

    <div class="modal-footer mt-1">
        <div class="col-md-12 mt-4">
            <button type="submit" class="btn btn-md btn-success">Save</button>
            <button type="reset" class="btn btn-info btn-md">Clear</button>
            <button type="button" class="btn btn-md btn-danger mr-auto" data-dismiss="modal">Exit</button>
        </div>
    </div>
</form>

<!-- Bootstrap Datepicker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {
        $('#date_picker').datepicker({
            format: 'mm/yyyy',
            autoclose: true,
            startView: 'months',
            minViewMode: 'months'
        });

        // Load members by team
        $('#marketing_team').change(function() {
            var teamId = $(this).val();
            if (teamId) {
                var url = '{{ route('get-team-members', ':teamId') }}'.replace(':teamId', teamId);
                $.get(url, function(data) {
                    $('#member_name').empty().append(
                        '<option value="">Select Member Name</option>');
                    $.each(data.members, function(index, member) {
                        $('#member_name').append('<option value="' + member
                            .person_no_pk + '">' + member.full_name + '</option>');
                    });
                });
            }
        });
    });

     $(document).ready(function () {
        $('#lookup-create').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submit

            const form = $(this);
            const url = form.attr('action');
            const formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                success: function (response) {
                    alert(response.title + ': ' + response.msg);
                    location.reload(); // Page reload after alert is closed
                },
                error: function (xhr) {
                    let message = 'An error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }
                    alert('Error: ' + message);
                }
            });
        });
    });
</script>
