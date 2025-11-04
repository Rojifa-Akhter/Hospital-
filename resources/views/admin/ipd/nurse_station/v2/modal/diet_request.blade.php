<style>
    .modal-dialog {
        position: relative;
        width: 90%;
        max-width: 1400px;
        margin: 1.75rem auto;
        pointer-events: none;
    }


    .modal-content {
        position: relative;
        display: flex;
        flex-direction: column;
        width: 100%;
        pointer-events: auto;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 0.3rem;
        outline: 0;
        justify-content: center;
    }
</style>

<!-- Patient Info Header -->
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-12 pb-4 text-center">
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                    {{ @$patient_info->patient_name }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                    {{ @$patient_info->patient_code }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                    {{ @$patient_info->admission_uid }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                    {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                    Department: {{ $patient_info->admitted_department }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                    {{ $patient_info->age }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender:
                    {{ $patient_info->gender_txt }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                    {{ $patient_info->bed_name }}</span>
                <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Consultant Name:
                    {{ $admission_info->primary_doctor_name }}</span>
            </div>
        </div>
    </div>
</div>
    
<form action="{{ route('v2.ipd-input-diet.store') }}" method="post" id="dietCreate">
    @csrf

    <!-- Diet Type, Feeding, Remarks -->
    <div class="row mb-3">
        <div class="col-md-2">
            <label><strong>Diet Type Category</strong></label>
            <select name="diet_type" class="form-control form-control-sm">
                <option value="NORMAL DIET">NORMAL DIET</option>
                <option value="SOFT DIET">SOFT DIET</option>
                <option value="LIQUID DIET">LIQUID DIET</option>
            </select>
        </div>
        <div class="col-md-2">
            <label><strong>NPO</strong></label>
            <select name="npo" class="form-control form-control-sm">
                <option value="">Select</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="col-md-2">
            <label><strong>Mode of Feeding</strong></label>
            <select name="feeding_mode" class="form-control form-control-sm">
                <option value="Oral">Oral</option>
                <option value="Tube Feeding">Tube Feeding</option>
                <option value="IV">IV</option>
            </select>
        </div>
        <div class="col-md-3">
            <label><strong>Remarks</strong></label>
            <input type="text" name="remarks" class="form-control form-control-sm">
        </div>
        <div class="col-md-3">
            <label><strong>Diagnosis*</strong></label>
            <input type="text" name="diagnosis" class="form-control form-control-sm">
        </div>
    </div>

    <div class="row">
        <!-- Ordered Diet List -->
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header"><strong>Ordered Diet</strong></div>
                <div class="card-body table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>Order By</th>
                                <th>Ack. By</th>
                                <th>Ack. Date</th>
                                <th>Diet Name</th>
                                <th>Status</th>
                                <th>Cancel</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($diet_requests as $diet)
                                <tr>
                                    <td>{{ $diet->diet_request_no_pk }}</td>
                                    <td>{{ $diet->au_entry_at }}</td>
                                    <td>{{ $diet->entry_by_name  }}</td>
                                    <td>{{ $diet->au_ack_by ?? '-' }}</td>
                                    <td>{{ $diet->au_ack_at ?? '-' }}</td>
                                    <td>
                                        <div><strong>Type:</strong> {{ $diet->diet_type }}</div>
                                        <div><strong>NPO:</strong> {{ $diet->npo }}</div>
                                        <div><strong>Feeding Mode:</strong> {{ $diet->feeding_mode }}</div>
                                        <div><strong>Remarks:</strong> {{ $diet->remarks }}</div>
                                        <div><strong>Diagnosis:</strong> {{ $diet->diagnosis }}</div>
                                        <div><strong>Food Precaution:</strong> {{ $diet->food_precaution }}</div>
                                        <div><strong>Diet Detail:</strong> {{ $diet->diet_detail }}</div>
                                        <div>
                                            <strong>Values:</strong>
                                            Protein: {{ $diet->protein }},
                                            Calories: {{ $diet->calories }},
                                            Salt: {{ $diet->salt }},
                                            Potassium: {{ $diet->potassium }},
                                            Fluids: {{ $diet->fluids }}
                                        </div>
                                        <div><strong>Food Habit:</strong> {{ $diet->food_habit }}</div>
                                    </td>
                                    <td>
                                        @if($diet->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" onclick="deleteDiet({{ $diet->diet_request_no_pk }})">Cancel</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No Record Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row">
        <div class="col-md-3">
            <div class="card-header"><strong>Food Precaution</strong></div>
            <div class="card-text" style="padding-left: 10px;"><strong>Name</strong></div>
            <div class="card-body">
                <textarea name="food_precaution" class="form-control form-control-sm" rows="5"></textarea>
            </div>
        </div>
        <!-- Current Diet Detail -->
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header"><strong>Current Diet Detail</strong></div>
                <div class="card-body">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="diet_detail[]"
                            value="Denture/Chewing Problem">
                        <label class="form-check-label">Denture/Chewing Problem</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="diet_detail[]" value="Supplements">
                        <label class="form-check-label">Supplements</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diet Values -->
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header"><strong>Diet Values</strong></div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label-sm">Protein (gm)</label>
                        <div class="col-md-9"><input type="text" name="protein" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label-sm">Calories (Kcal)</label>
                        <div class="col-md-9"><input type="text" name="calories"
                                class="form-control form-control-sm"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label-sm">Salt (gm)</label>
                        <div class="col-md-9"><input type="text" name="salt" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label-sm">Potassium (mEq/1)</label>
                        <div class="col-md-9"><input type="text" name="potassium"
                                class="form-control form-control-sm"></div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label-sm">Fluids (ml)</label>
                        <div class="col-md-9"><input type="text" name="fluids" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Food Precaution / Habit -->
        <div class="col-md-3">
            <div class="card mb-3">
                <div class="card-header"><strong>Food Habit</strong></div>
                <div class="card-text" style="padding-left: 10px;"><strong>Name</strong></div>
                <div class="card-body">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="food_habit[]" value="VEG">
                        <label class="form-check-label">VEG</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="food_habit[]" value="NON-VEG">
                        <label class="form-check-label">NON-VEG</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="food_habit[]" value="EGGETARIAN">
                        <label class="form-check-label">EGGETARIAN</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="food_habit[]"
                            value="NO ONION NO GARLIC">
                        <label class="form-check-label">NO ONION NO GARLIC</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Fields -->
    <input type="hidden" name="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" value="{{ $admission_id }}">

    <!-- Buttons -->
    <div class="modal-footer">
        @php
            $response_action = route('v2.ipd.nurse-note', $admission_id);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
            Save
        </button>
        <button type="reset" class="btn btn-info btn-md">Clear</button>
    </div>
</form>

<script>
    $("#dietCreate").validate({
        rules: {
            diet_type: {
                required: true
            },
            feeding_mode: {
                required: true
            },
            food_type: {
                required: true
            },
        },
        messages: {
            diet_type: {
                required: "Diet Type Required"
            },
            feeding_mode: {
                required: "Feeding Mode Required"
            },
            food_type: {
                required: "Food Type Required"
            },
        }
    })
</script>

<script>
    function deleteDiet(id) {
        if(!confirm("Are you sure you want to cancel this diet request?")) return;

        fetch("{{ url('/v2.ipd-diet-request') }}/" + id, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                alert(data.message);
                location.reload(); // refresh table
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(err => alert("Error: " + err));
    }
</script>
