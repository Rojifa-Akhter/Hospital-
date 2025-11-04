<div class="card-header ">
    <h5>Registered Patient List</h5>
</div>

<div class="card-body">
    <div class="row mt-2">
        <div class="col-md-12 table-responsive">
            <table class="table table-bordered table-hover table-striped data-table">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col">#SL</th>
                        <th scope="col">Image</th>
                        <th scope="col">Patient Id</th>
                        <th scope="col">Patient Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Email</th>
                        <th scope="col">Address</th>
                        <th scope="col">Corporate Info</th>
                        <th scope="col">Referred By</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        var searchdata = $('#patient-search').serialize();
        var datatable = $('.data-table').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "language": {
                "infoFiltered": ""
            },

            "ajax": {
                "url": "{{ url('patient-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}",
                    searchdata: searchdata
                }
            },
            "columnDefs": [{
                    "targets": 1,
                    "render": function(data, type, row, meta) {

                        if (row[9] != null) {
                            return '<img src="images/uploads/patient_images/thumb/' + row[9] +
                                '" >';
                        } else {
                            if (row[4] == 'Male') {
                                return '<img src="images/pt-patient.jpg" width="50" >';
                            } else {
                                return '<img src="images/female-doc.jpg" width="50" >';
                            }
                        }
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        // var age = row[3] != null ? "<br> Age : " + row[3] : "";
                        // var Gender = row[4] != null ? "<br> Gender : " + row[4] : "";
                        // var Mobile = row[5] != null ? "<br>  Mobile No : " + row[5] : "";
                        // var Email = row[7] != null ? "<br> Email : " + row[7] : "";

						return  row[1];
					}
				},
				{
					"targets": 3,
					"data": "Edit",
					"render": function(data, type, row, meta) {

						return   row[2] ;
					}
				},
				{
					"targets": 4,
					"data": "Edit",
					"render": function(data, type, row, meta) {
						var age = row[3] != null ?  row[3] : "";


						return  age ;
					}
				},
				{
					"targets": 5,
					"data": "Edit",
					"render": function(data, type, row, meta) {
						var Gender = row[4] != null ? row[4] : "";

						return  Gender ;
					}
				},
				{
					"targets": 6,
					"data": "Edit",
					"render": function(data, type, row, meta) {
						var Mobile = row[5] != null ? row[5] : "";

						return  Mobile ;
					}
				},
                {
                    "targets": 7,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var Email = row[7] != null ?  row[7] : "";

                        return Email;
                    }
                },
                {
                    "targets": 8,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {



                        return row[6];
                    }
                },

                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var ccm_client_name = row[10] != null ?
                            " <strong> Corporate Name : </strong>" + row[10] : "";
                        var ccm_client_code = row[11] != null ?
                            "<br><strong> Corporate Code : </strong> " + row[11] : "";
                        var contact_person = row[12] != null ?
                            "<br><strong>  Contact Person : </strong>" + row[12] : "";
                        var contact_no = row[13] != null ?
                            "<br><strong> Contact No : </strong>" + row[13] : "";
                        var contract_sign_date = row[14] != null ?
                            "<br><strong> Contact Singing Date : </strong>" + row[14] : "";

                        return ccm_client_name + ccm_client_code + contact_person + contact_no;
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var referral = row[15] != null ?  row[15] : row[16];
                        return referral;
                    }
                },
                {
                    "targets": 11,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var status = row[8] == 1 ?
                            "<span style='text-align: center'> Active </span>" :
                            "<span style='text-align: center'>Inactive</span>";

                        return status;
                    }
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var show_action = '{{ route('registration.show', ':id') }}';
                        show_action = show_action.replace(':id', row[0]);

                        var edit_action = '{{ route('registration.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[0]);

                        var card_action = '{{ route('patient-card', ':id') }}';
                        card_action = card_action.replace(':id', row[0]);

                        return '<span  Class="btn btn-sm btn-dark open-modal" data-id="' + row[
                                0] + '" data-action="' + show_action +
                            '" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information"><i class="fa fa-eye"></i></span>&nbsp;<span  Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[0] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Patient Information" title="Edit Patient Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span  Class="btn btn-sm btn-success open-modal" data-id="' +
                            row[0] + '" data-action="' + card_action +
                            '" data-modal="common-modal-sm" title="Card" data-title="Membership Card"><i class="fa fa-address-card "></i></span>';
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return meta.row + meta.settings._iDisplayStart + 1;

                        // return `${meta.row + 1}`;
                    }
                },
            ]
        });
    });

    $(document).on('click', '#searchPatient', function() {

        // var formID = $("#patient-search").attr("id");
        // var formMethod = $("#frmSearch").attr("method");
        $('.data-table').empty();
        $('.data-table').DataTable().destroy();

        var searchdata = $('#patient-search').serialize();

        var datatable = $('.data-table').DataTable({
            "searching": false,
            "processing": true,
            "serverSide": true,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ url('patient-search') }}",
                "dataType": "json",
                "type": "POST",

                data: {
                    hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                    patient_gender: $('#patient_gender').val(),
                    patient_age: $('#patient_age').val(),
                    patient_nid: $('#patient_nid').val(),
                    patient_marital_status: $('#patient_marital_status').val(),
                    patient_religion: $('#patient_religion').val(),
                    patient_status: $('#patient_status').val(),
                    patient_blood: $('#patient_blood').val(),
                    patient_type: $('#patient_type').val(),
                    corporate_name: $('#corporate_name').val(),
                    search_date_from: $('#search_date_from').val(),
                    search_date_to: $('#search_date_to').val(),
                }
            },
            "columnDefs": [{
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        if (row[9] != null) {
                            return '<img src="../public/images/uploads/patient_images/thumb/' +
                                row[9] + '" >';
                        } else {
                            if (row[4] == 'Male') {
                                return '<img src="../public/images/pt-patient.jpg" width="50" >';
                            } else {
                                return '<img src="../public/images/female-doc.jpg" width="50" >';
                            }
                        }
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        // var age = row[3] != null ? "<br> Age : " + row[3] : "";
                        // var Gender = row[4] != null ? "<br> Gender : " + row[4] : "";
                        // var Mobile = row[5] != null ? "<br>  Mobile No : " + row[5] : "";
                        // var Email = row[7] != null ? "<br> Email : " + row[7] : "";

						return  row[1];
					}
				},
				{
					"targets": 3,
					"data": "Edit",
					"render": function(data, type, row, meta) {

						return   row[2] ;
					}
				},
				{
					"targets": 4,
					"data": "Edit",
					"render": function(data, type, row, meta) {
						var age = row[3] != null ? row[3] : "";


						return  age ;
					}
				},
				{
					"targets": 5,
					"data": "Edit",
					"render": function(data, type, row, meta) {
						var Gender = row[4] != null ? row[4] : "";

						return  Gender ;
					}
				},
				{
					"targets": 6,
					"data": "Edit",
					"render": function(data, type, row, meta) {
						var Mobile = row[5] != null ?  row[5] : "";

						return  Mobile ;
					}
				},
                {
                    "targets": 7,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var Email = row[7] != null ? "<br> Email : " + row[7] : "";

                        return Email;
                    }
                },
                {
                    "targets": 8,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {



                        return row[6];
                    }
                },

                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var ccm_client_name = row[10] != null ?
                            " <strong> Corporate Name : </strong>" + row[10] : "";
                        var ccm_client_code = row[11] != null ?
                            "<br><strong> Corporate Code : </strong> " + row[11] : "";
                        var contact_person = row[12] != null ?
                            "<br><strong>  Contact Person : </strong>" + row[12] : "";
                        var contact_no = row[13] != null ?
                            "<br><strong> Contact No : </strong>" + row[13] : "";
                        var contract_sign_date = row[14] != null ?
                            "<br><strong> Contact Singing Date : </strong>" + row[14] : "";

                        return ccm_client_name + ccm_client_code + contact_person + contact_no;
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var referral = row[15] != null ?  row[15] : row[16];
                        return referral;
                    }
                },
                {
                    "targets": 11,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var status = row[8] == 1 ?
                            "<span style='text-align: center'> Active </span>" :
                            "<span style='text-align: center'>Inactive</span>";

                        return status;
                    }
                },
                {
                    "targets": -1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {

                        var show_action = '{{ route('registration.show', ':id') }}';
                        show_action = show_action.replace(':id', row[0]);

                        var edit_action = '{{ route('registration.edit', ':id') }}';
                        edit_action = edit_action.replace(':id', row[0]);

                        var card_action = '{{ route('patient-card', ':id') }}';
                        card_action = card_action.replace(':id', row[0]);

                        return '<span  Class="btn btn-sm btn-dark open-modal" data-id="' + row[
                                0] + '" data-action="' + show_action +
                            '" data-modal="common-modal" data-title="View Patient Information" title="View Patient Information"><i class="fa fa-eye"></i></span>&nbsp;<span  Class="btn btn-sm btn-primary open-modal" data-id="' +
                            row[0] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Patient Information" title="Edit Patient Information"><i class="fa fa-pencil-alt"></i></span>&nbsp;<span  Class="btn btn-sm btn-success open-modal" data-id="' +
                            row[0] + '" data-action="' + card_action +
                            '" data-modal="common-modal-sm" title="Card" data-title="Membership Card"><i class="fa fa-address-card "></i></span>';
                    }
                },
                {
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {


                        // return `${meta.row + 1}`;
                           return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
            ]
        });
    });
</script>
