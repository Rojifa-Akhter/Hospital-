@if (isset($employee_info))
    @foreach ($employee_info as $employee)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @if ($employee->photo_name != null)
                    <img src="{{ asset('images/uploads/doctor_images/thumb/' . $employee->photo_name) }}">
                @else
                    @if ($employee->gender_txt == 'Male')
                        <img src="../public/images/doc-1.png" width="50">
                    @else
                        <img src="../public/images/nurse-2.png" width="50">
                    @endif
                @endif

            </td>
            {{-- <td> {{ $employee->person_code }} </td> --}}
            <td> {{ $employee->card_no }} </td>
            <td> {{ $employee->full_name }} </td>
            <td> {{ $employee->age }} </td>
            <td> {{ $employee->gender_txt }} </td>
            <td> {{ $employee->specialization }} </td>
            <td> {{ $employee->designation }} </td>
            <td> {{ $employee->serviceunit_no_fk_dept_name }} </td>
            <td> {{ $employee->su_name }} </td>
            <td> Phone :{{ $employee->phone_mobile }} <br> Email :{{ $employee->email_personal }} </td>
            <td> {{ $employee->pe_addr1 }} </td>

            <td>
                @if ($employee->status == 1)
                    <span class="badge badge-md badge-success"> Active</span>
                @else
                    <span class="badge badge-md badge-secondary"> Inactive</span>
                @endif
            </td>
            <td>
                <span Class="btn btn-sm open-modal" style="background-color: #770CCB"
                    data-id="{{ $employee->person_no_pk }}"
                    data-action="{{ route('doctor.show', $employee->person_no_pk) }}" data-modal="common-modal"
                    data-title="View Employee Information" title="View Employee Information"><i
                        class="fa fa-eye text-white"></i></span>

                <span Class="btn btn-sm btn-primary open-modal" data-id="{{ $employee->person_no_pk }}"
                    data-action="{{ route('update_employeeV1', $employee->person_no_pk) }}" data-modal="common-modal"
                    data-title="Edit Employee Information" title="Edit Employee Information"><i
                        class="fa fa-pencil-alt"></i></span>
                @if (Session::get('user.ses_hospital_code') == "UNICO") 
                    <a Class="btn btn-sm btn-success" title="Card"
                    href="{{ route('employee-card-print-uhl', $employee->person_no_pk) }}" target="_blank"><i class="fa fa-address-card"></i>
                    </a> 
                @endif
                     
                {{-- <span data-id="" Class="btn btn-sm btn-success" title="Card"><i
                        class="fa fa-address-card "></i></span>&nbsp; --}}
                {{-- <span Class="btn btn-sm open-modal" style="background-color: rgb(249, 72, 125)"
                    data-id="{{ $employee->person_no_pk }}"
                    data-action="{{ route('doctor-schedule', $employee->person_no_pk) }}" data-modal="common-modal"
                    data-title="Create Schedule" title="Create Schedule"><i
                        class="fa fa-calendar-plus text-white"></i></span> --}}
{{-- 
                &nbsp;<span Class="btn btn-sm open-modal" style="background-color: #FFA500" title="Billing Setup"
                    data-modal="common-modal-sm" data-title="Employee Fee"
                    data-action="{{ route('doctor-fee-setup', $employee->person_no_pk) }}"><i
                        class="fa fa-money-bill text-white"></i></span> --}}

                <span Class="btn btn-sm open-modal" style="background-color: #FFA500" title="Promotion History"
                    data-modal="common-modal-md" data-title="Promotion History"
                    data-action="{{ route('promotion-history', $employee->person_no_pk) }}"><i
                    class="fa fa-eye text-white"></i></span>

                <span Class="btn btn-sm open-modal" style="background-color: #FFA500" title="Increment History"
                    data-modal="common-modal-md" data-title="Increment History"
                    data-action="{{ route('increment-history', $employee->person_no_pk) }}"><i
                    class="fa fa-eye text-white"></i></span>

            </td>
        </tr>
    @endforeach
@endif
