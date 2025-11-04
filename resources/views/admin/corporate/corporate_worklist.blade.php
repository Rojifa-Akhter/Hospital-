<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body mt-3">
                <div class="table-responsive border-top border-right">
                    <table id="datatable" class="table table-bordered table-hover mb-0">
                        <thead class="bg-light-blue">
                            <tr>
                                <th class="text-center">Sl</th>
                                <th class="text-center">Corporate Code</th>
                                <th class="text-center">Corporate</th>
                                <th class="text-center">Corporate Entry Date</th>
                                <th class="text-center">Signatory</th>
                                <th class="text-center">Contact Sign Date</th>
                                <th class="text-center">Total Registered Staff</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 150px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($work_list))
                                @foreach ($work_list as $data)
                                    @php
                                        if ($data->active_status == 1) {
                                            $value = 'Active';
                                            $class = 'primary';
                                        } elseif ($data->active_status == 2) {
                                            $value = 'Proposed';
                                            $class = 'success';
                                        } else {
                                            $value = 'Inactive';
                                            $class = 'danger';
                                        }

                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $data->ccm_client_code }}</td>
                                        <td class="text-left">
                                            <div class="dept_info">
                                                <div>
                                                    <strong>Name:
                                                    </strong>{{ !empty($data->ccm_client_name) ? $data->ccm_client_name : '' }}
                                                </div>
                                                <div>
                                                    <strong>Address:
                                                    </strong>{{ !empty($data->client_address) ? $data->client_address : '' }}
                                                </div>
                                                <div>
                                                    <strong>Contact Person:
                                                    </strong>{{ !empty($data->contact_person) ? $data->contact_person : '' }}
                                                </div>
                                                <div>
                                                    <strong>Contact:
                                                    </strong>{{ !empty($data->contact_no) ? $data->contact_no : '' }}
                                                </div>
                                                <div>
                                                    <strong>Designation:
                                                    </strong>{{ !empty($data->designation_name) ? $data->designation_name : '' }}
                                                </div>
                                                <div>
                                                    <strong>Email:
                                                    </strong>{{ !empty($data->official_email) ? $data->official_email : '' }}
                                                </div>
                                            </div>
                                        </td>
                                        {{-- {{dd($data->au_entry_at)}} --}}

                                        <td class="text-left">
                                            {{ !empty($data->au_entry_at) ? date('d/m/Y', strtotime($data->au_entry_at)) : 'N/A' }}
                                        </td>

                                        <td class="text-left">
                                            <div class="dept_info">
                                                <div>
                                                    <strong>Name:
                                                    </strong>{{ !empty($data->signatory_name) ? $data->signatory_name : '' }}
                                                </div>
                                                <div>
                                                    <strong>Designation:
                                                    </strong>{{ !empty($data->designation_name1) ? $data->designation_name1 : '' }}
                                                </div>
                                                <div>
                                                    <strong>Contact Person:
                                                    </strong>{{ !empty($data->signatory_contact_number) ? $data->signatory_contact_number : '' }}
                                                </div>
                                                <div>
                                                    <strong>Email:
                                                    </strong>{{ !empty($data->signatory_email) ? $data->signatory_email : '' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-left">
                                            {{ !empty($data->contract_sign_date) ? date('d/m/Y', strtotime($data->contract_sign_date)) : 'N/A' }}
                                        </td>
                                        <td class="text-center">{{ $data->total_register_staff }}</td>
                                        <td class="text-center">
                                            {{-- @if ($data->active_status) --}}

                                            <span class="badge badge-{{ $class }}">

                                                {{ $value }}
                                            </span>
                                            {{-- @endif --}}

                                        </td>

                                        <td class="text-center">
                                            <div>
                                                <span
                                                    class="badge badge-md badge-success p-1 mb-1 cursor-pointer open-modal"
                                                    data-id="{{ $data->ccm_client_no_pk }}"
                                                    data-action="{{ route('corporate-form-edit', $data->ccm_client_no_pk) }}"
                                                    data-modal="common-modal-md"
                                                    data-title="Edit Corporate Entry"><i
                                                        class="far fa-edit"></i> Edit</span>

                                                <span
                                                    class="badge badge-md badge-primary p-1 mb-1 cursor-pointer open-modal"
                                                    data-id="{{ $data->ccm_client_no_pk }}"
                                                    data-action="{{ route('corporate.staff-add.form', $data->ccm_client_no_pk) }}"
                                                    data-modal="common-modal-sm"
                                                    data-title="Add Corporate Staff">Add Staff</span>

                                                {{-- <span
                                                    class="badge badge-md badge-info p-1 mb-1 cursor-pointer">Proposal</span>
                                                <span
                                                    class="badge badge-md badge-warning p-1 mb-1 cursor-pointer">Policy
                                                    Set</span> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
