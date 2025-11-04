<div class="col-lg-12 col-md-12 col-sm-12">
<div style="height: 400px; overflow-y: auto;">
    <table class="table mt-3">
        <tbody>
            <tr>
                <th width="15%"><label for="medical_history" class="col-form-label">Medical History</label></th>
                <td>
                    <input type="text" class="form-control" id="medical_history" name="medical_history" value="{{ !empty($lmp) ? $lmp->medical_history : '' }}">
                </td>
            </tr>
            <tr>
                <th><label for="family_history" class="col-form-label">Family History</label></th>
                <td>
                    <input type="text" class="form-control" id="family_history" name="family_history" value="{{ !empty($lmp) ? $lmp->family_history : '' }}">
                </td>
            </tr>
            <tr>
                <th><label for="surgical_history" class="col-form-label">Surgical History</label></th>
                <td>
                    <input type="text" class="form-control mb-0" id="surgical_history" name="surgical_history" placeholder=""
                            value="{{ isset($lmp->surgical_history) ? $lmp->surgical_history : '' }}">
                </td>
            </tr>

            <tr>
                <th><label for="past_history" class="col-form-label">Past History</label></th>
                <td>
                    <input type="text" class="form-control" id="past_history" name="past_history" value="{{ !empty($lmp) ? $lmp->past_history : '' }}">
                </td>
            </tr>

            {{-- <tr>
                <th><label for="risk_factor" class="col-form-label">Risk Factor</label></th>
                <td>
                    <input type="text" class="form-control" id="risk_factor" name="risk_factor" value="">
                </td>
            </tr> --}}
        </tbody>
    </table>
</div>
</div>
