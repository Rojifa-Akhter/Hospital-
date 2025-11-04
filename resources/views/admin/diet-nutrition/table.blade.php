<div class="">
    <div class="col-md-12" id="">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped data-table" id="dataTable">
                <thead class="global-uhl-table-bg">
                    <tr class="text-center">
                        <th>#</th>
                        <th>SL</th>
                        <th>Admission No</th>
                        <th>Admission Date</th>
                        <th>Patient ID</th>
                        <th>Patient Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Mobile No</th>
                        <th>Ward</th>
                        <th>Bed</th>
                        <th>Primary Doctor</th>
                        <th>Nurse Station</th>
                        <th style="width: 110px;">Diet Chart</th>
                        <th style="width: 110px;">Diet Nature</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($items)
                        @foreach ($items as $item)
                            <tr style="{{ $item->diet_chart_no_fk != null ? 'background-color: #e0f2f1' : '' }}">
                                <td>
                                    {{-- <input type="checkbox" name="check" value="{{ $item->admission_no_pk }}" patient_no_fk="{{ $item->patient_no_fk }}" class="check" {{ date('Y-m-d') == date('Y-m-d', strtotime($item->diet_date)) ? 'disabled' : '' }} /> --}}
                                    <input type="checkbox" name="check" value="{{ $item->admission_no_pk }}"
                                        patient_no_fk="{{ $item->patient_no_fk }}" class="check" />
                                </td>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $item->admission_no_pk }}</td>
                                <td class="text-center">{{ date('d/m/Y', strtotime($item->admission_date)) }}</td>
                                <td class="text-center">{{ $item->patient_no_fk }}</td>
                                <td>{{ $item->patient_name }}</td>
                                <td class="text-center">{{ date('d/m/Y', strtotime($item->dob)) }}</td>
                                <td>{{ $item->gender_txt }}</td>
                                <td class="text-center">{{ $item->mobile1 }}</td>
                                <td class="text-left">{{ $item->ward_name }}</td>
                                <td class="text-left">{{ $item->bed_name }}</td>
                                <td class="text-left">{{ $item->primary_doctor_name }}</td>
                                <td class="text-left">{{ $item->nurse_station }}</td>
                                <td>
                                    {{-- <button type="button" class="btn btn-info btn-sm open-modal" data-modal="common-modal-sm" data-title="Diet Input" data-action="{{ route('dietNutrition.dietEntry', ['10993', '4763']) }}">
                                        Diet Input
                                    </button> --}}

                                    <select class="form-control diet_chart_no_pk" name="diet_chart_no_pk"
                                        admission_no_pk="{{ $item->admission_no_pk }}" {{-- {{ date('Y-m-d') == date('Y-m-d', strtotime($item->diet_date)) && $item->diet_chart_no_fk != null ? 'disabled' : '' }} --}}>
                                        <option selected disabled>Diet Chart</option>
                                        @foreach ($dietCharts as $dietChart)
                                            <option value="{{ $dietChart->diet_chart_no_pk }}" {{-- {{ date('Y-m-d') == date('Y-m-d', strtotime($item->diet_date)) && $item->diet_chart_no_fk == $dietChart->diet_chart_no_pk ? 'selected' : '' }} --}}
                                                {{ $item->diet_chart_no_fk == $dietChart->diet_chart_no_pk ? 'selected' : '' }}>
                                                {{ $dietChart->diet_chart_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control diet_nature" name="diet_nature"
                                        admission_no_pk="{{ $item->admission_no_pk }}" {{-- {{ date('Y-m-d') == date('Y-m-d', strtotime($item->diet_date)) && $item->diet_type != null ? 'disabled' : '' }} --}}>
                                        <option selected disabled>Diet Nature</option>
                                        <option value="solid" {{-- {{ date('Y-m-d') == date('Y-m-d', strtotime($item->diet_date)) && $item->diet_type == "solid" ? 'selected' : ''  }}\ --}}
                                            {{ $item->diet_type == 'solid' ? 'selected' : '' }}>Solid</option>
                                        <option value="liquid" {{-- {{ date('Y-m-d') == date('Y-m-d', strtotime($item->diet_date)) && $item->diet_type == "liquid" ? 'selected' : ''  }} --}}
                                            {{ $item->diet_type == 'liquid' ? 'selected' : '' }}>Liquide</option>
                                        <option value="ng" {{-- {{ date('Y-m-d') == date('Y-m-d', strtotime($item->diet_date)) && $item->diet_type == "ng" ? 'selected' : ''  }} --}}
                                            {{ $item->diet_type == 'ng' ? 'selected' : '' }}>N.G</option>
                                    </select>
                                </td>
                                <td>
                                    @if (session()->get('user.serviceunit_code') === 'nutrition')
                                        <a href="{{ route('dietNutrition.entry', ['patient_id' => $item->patient_no_fk, 'admission_id' => $item->admission_no_pk]) }}"
                                            class="btn btn-sm btn-success"><i
                                                class="fa fa-check-circle"></i></a>
                                    @endif
                                    <a href="{{ route('dietNutrition.history', ['id' => $item->admission_no_pk]) }}"
                                        target="_blank" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('dietNutrition.dietCard', ['id' => $item->admission_no_pk]) }}"
                                        target="_blank" class="btn btn-sm btn-info"><i class="fa fa-file"></i></a>
                                    <a href="{{ route('ipd_case_sheet', ['patient_id' => $item->patient_no_fk, 'admission_id' => $item->admission_no_pk]) }}"
                                        target="_blank" class="btn btn-sm btn-info"><i class="fa fa-receipt"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            ordering: true,
            bPaginate: true,
            bLengthChange: true,
            bAutoWidth: false,
            columnDefs: [{
                    targets: [0, 1, 2, 3, 5, 7, 11, ],
                    className: 'text-center'
                },
                {
                    targets: [4, 6, 8, 9, 10, ],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [5, 10, 25, 50, 75, 100, -1],
                [5, 10, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 10
        });
        $('th').addClass('text-center');
    });
</script>
