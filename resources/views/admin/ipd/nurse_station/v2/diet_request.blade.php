<style>
    .custom-form {
        width: 100%;
        border: none;
        outline: none;
    }

    .border-left-0 {
        border-left: none !important;
    }

    .border-right-0 {
        border-right: none !important;
    }

    .medicine_thead {
        background-color: #e1e1e5;
    }

    .w-15 {
        width: 15%;
    }

    .w-25 {
        width: 25%;
    }

    .w-8 {
        width: 8%;
    }

    .w-6 {
        width: 6%;
    }

    .w-16 {
        width: 16%;
    }

    .remove_row {
        cursor: pointer;
        background-color: white;
    }

    .fa-star {
        display: none;
    }

    thead {
        position: sticky;
        top: 0px;
        left: 0px;
        right: 0px;
        background-color: white;
    }

    .fs-12 {
        font-size: 14px;
    }

    .pdf-icon {
        font-size: 22px;
        color: red
    }

    .add-btn {

        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;

    }

    #medTable input,
    #painTable input,
    #monitorTable input {
        width: 100%;

    }

    #medTable th,
    #painTable th,
    #monitorTable th {
        font-size: 14px
    }

    #medTable th,
    #painTable th,
    #monitorTable th #medTable td,
    #painTable td,
    #monitorTable td {
        text-align: center;
    }


    .add-col-btn:hover {
        color: darkgreen;
        transform: scale(1.2);
    }

    .remove-col-btn {
        cursor: pointer;
        background: #CF5C46;
        color: white;
        border: none;
        padding: 2px 5px;
        font-size: 12px;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Diet Chart</h5>
                            <small>IPD / Nurse Station / Diet Chart</small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
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

                                <div class="col-md-12">
                                    <form action="{{ route('v2.ipd-input-diet.store') }}" method="post"
                                        id="dietCreate">
                                        @csrf
                                        
                                        <h5 class="text-center mb-4 border-bottom p-2">Diet Chart</h5>

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
                                                    <div class="">
                                                        <table class="table-sm table-bordered">
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
                                                <div class="card mb-3">
                                                    <div class="card-header"><strong>Food Precaution</strong></div>
                                                    <div class="card-text" style="padding-left: 10px;"><strong>Name</strong></div>
                                                    <div class="card-body">
                                                        <textarea name="food_precaution" class="form-control form-control-sm" rows="5"></textarea>
                                                    </div>
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

                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('v2.ipd.input-diet', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp

                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doctor_name', 'h_doctor_name', 'employee_ind', '1');

</script>

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
