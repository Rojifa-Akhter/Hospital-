<div class="card-header ">
    <h5>Registered Patient List</h5>
</div>

<div class="card-body">
    <div class="row mt-2">
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered table-hover table-striped data_table" id="dataTable">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col" style="width: 30px;">#SL</th>
                        <th scope="col">Image</th>
                        <th scope="col">Patient Id</th>
                        <th scope="col" width="140px">Patient Name</th>
                        <th scope="col" width="100px">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col" style="width: 230px;">Corporate Info</th>
                        <!-- <th scope="col">Email</th> -->
                        <th scope="col">Status</th>
                        <th scope="col" width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $index => $item)
                        @php
                            $photo = '';
                            if ($item->patient_photo != null) {
                                $photo = '<img src="images/uploads/patient_images/thumb/'. $item->patient_photo . '" />';
                            } else {
                                if ($item->gender_txt == 'Male') {
                                    $photo = '<img src="images/pt-patient.jpg" width="50" />';
                                } else {
                                    $photo = '<img src="images/female-doc.jpg" width="50" />';
                                }
                            }
                        @endphp
                        <tr>
                            <td>{{ ++$index }}</td>
                            <td style="align-content: center;">{!! $photo !!}</td>
                            <td style="text-align: left;">{{ $item->patient_code }}</td>
                            <td>{{ $item->patient_name }}</td>
                            <td>
                                @php
                                    $pat_dob = new \DateTime($item->dob);
                                    $current_date = new \DateTime();
                                    $pat_dob->modify('-1 day');
                                    $interval = $current_date->diff($pat_dob);
                                    echo $interval->format('%yY %mM %dD');
                                @endphp
                            </td>
                            <td>{{ $item->gender_txt }}</td>
                            <td>{{ $item->mobile1 }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->present_addr }}</td>
                            <td>
                                @php
                                    if($item->ccm_client_name != '') echo '<strong> Corporate Name : </strong>' . $item->ccm_client_name;
                                    if($item->ccm_client_code != '') echo '<strong> Corporate Code : </strong>' . $item->ccm_client_code;
                                    if($item->contact_person != '') echo '<strong> Contact Person : </strong>' . $item->contact_person;
                                    if($item->contact_no != '') echo '<strong> Contact No : </strong>' . $item->contact_no;
                                    if($item->contract_sign_date != '') echo '<strong> Contact Singing Date : </strong>' . $item->contract_sign_date;
                                @endphp
                            </td>
                            <td>
                                @if($item->status == '1') <span class="badge badge-success">Active</span>
                                @else <span class="badge badge-danger">Inactive</span>;
                                @endif
                            </td>
                            <td>
                                <span class="btn btn-sm btn-dark open-modal" data-id="{{ route('registration.show', ['registration' => $item->patient_no_pk]) }}" data-action="{{ route('registration.show', ['registration' => $item->patient_no_pk]) }}" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information"><i class="fa fa-eye"></i></span>
                                <span class="btn btn-sm btn-primary open-modal" data-id="{{ route('registration.edit', ['registration' => $item->patient_no_pk]) }}" data-action="{{ route('registration.edit', ['registration' => $item->patient_no_pk]) }}" data-modal="common-modal-md" data-title="Edit Patient Information" title="Edit Patient Information"><i class="fa fa-pencil-alt"></i></span>
                                <span class="btn btn-sm btn-success open-modal" data-id="{{ route('patient-card', ['id' => $item->patient_no_pk]) }}" data-action="{{ route('patient-card', ['id' => $item->patient_no_pk]) }}" data-modal="common-modal-sm" title="Card" data-title="Membership Card"><i class="fa fa-address-card "></i></span>
                                <a class="btn btn-sm btn-info" data-id="" href="{{ route('general-consent') }}" target="_blank" title="General Consent"><i class="fa fa-file-pdf"></i></a>
                                <a class="btn btn-sm btn-info" data-id="" href="{{ route('patient-information-pdf', ['id' => $item->patient_no_pk]) }}" target="_blank" title="Patient Information"><i class="fa fa-file-pdf"></i></a>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    // $("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 1, 10], className: 'text-center' },
                    { targets: [2, 3, 4, 5, 6, 7, 8, 9], className: 'text-left' }
                ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');
    });
</script>
