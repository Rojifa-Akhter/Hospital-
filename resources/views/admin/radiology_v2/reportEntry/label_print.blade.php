<!-- DataTables CSS CDN -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
    *::after,
    *::before {
        margin: 0;
        padding: 3px !important;
        box-sizing: border-box;
    }

    #invoice_id {
        text-align: center;
    }

    #search_btn {
        margin-left: 10px;
    }
</style>

<section id="full_invoice">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 text-left">
                <h5 class="mt-2 mb-0">Radiology Label Print</h5>
                <small>Scan Invoice ID and Print Label</small>
            </div>
        </div>

        <div class="card mt-2" style="width: 100%; margin: auto;">
            <div class="card-header" style="background: #6cb2eb;">
                <h5><span style="color: #fff;">Radiology Label Print</span></h5>
            </div>

            <div class="card-body">
                {{-- Invoice Form --}}
                <form method="POST" id="frmSubmit" action="{{ route('search-reports.label-print') }}">
                    @csrf
                    <div class="form-row pb-3 justify-content-center">
                        <label for="invoice_id" class="col-form-label col-form-label-sm mr-2">Scan Invoice ID</label>
                        <input type="text" class="form-control form-control-sm text-center col-md-2" id="invoice_id"
                            name="invoice_id" placeholder="Scan Invoice ID">
                        <button type="button" id="search_btn" class="btn btn-primary btn-sm">Search</button>
                    </div>
                </form>

                {{-- Data Table --}}
                <table id="radiologyTable" class="display table table-bordered table-striped" style="width:100%">
                    <thead class="sticky_header bg-light-blue">
                        <tr>
                            <th>SL#</th>
                            <th>Invoice ID.</th>
                            {{-- <th>Invoice No PK</th> --}}
                            <th>UHID</th>
                            <th>Patient Name</th>
                            <th>Department</th>
                            <th>Item Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="pr_result">
                        {{-- ডাটা Ajax দিয়ে আসবে --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS CDN -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#invoice_id').focus();

        // DataTable Initialize (empty initially)
        let table = $('#radiologyTable').DataTable({
            "processing": true,
            "columns": [{
                    "data": "sl"
                },
                {
                    "data": "invoice_code"
                },
                {
                    "data": "patient_code"
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        if (type === 'display') {
                            var patientPhoto = row.patient_photo;
                            var gender = row.gender_txt;
                            var photoUrl = '';
                            if (patientPhoto && patientPhoto !== '') {
                                photoUrl = '/images/uploads/patient_images/thumb/' +
                                    patientPhoto;

                                // const photoUrl = "{{ asset('images/uploads/patient_images/thumb') }}/" + patientPhoto;
                            } else {
                                if (gender === 'Male') {
                                    photoUrl = '/images/pt-patient.png';
                                } else {
                                    photoUrl = '/images/female.jpg';
                                }
                            }
                            console.log(photoUrl)
                            const fullPath = window.location
                                .pathname; // /h360_uhl/public/radiology/result-entry-wl-direct
                            const pathSegments = fullPath.split(
                                "/"); // ["", "h360_uhl", "public", "radiology", ...]
                            const basePath = "/" + pathSegments[1] + "/" + pathSegments[
                                2]; // /h360_uhl/public
                            const baseUrl = window.location.origin + basePath;

                            console.log(baseUrl); // http://192.168.1.53/h360_uhl/public
                            var patientCode = row.patient_code || '';
                            var patientName = row.patient_name || '';
                            var mobile = row.mobile1 || '';
                            var patientId = row.patient_no_fk || '';
                            var actionUrl = patientId ?
                                `${baseUrl}/registration/show/${patientId}` : '';

                            return `
                        <div class="doctor_info">
                            <span class="open-modal" data-id="${patientId}"
                                data-action="${actionUrl}" data-modal="common-modal"
                                data-title="View Patient Information" title="View Patient Information">
                                <img class="rounded" src="${baseUrl + photoUrl}">
                                <div class="doctor_info_data">
                                    <ul style="list-style: none;">
                                        <li class="cursor-pointer"><u><strong>${patientCode}</strong></u></li>
                                        <li class="cursor-pointer"><u>${patientName}</u></li>
                                        <li>${gender}, ${mobile}</li>
                                    </ul>
                                </div>
                            </span>
                        </div>
                    `;
                        }
                        return row.patient_name;
                    }
                },
                {
                    "data": "serviceunit_name"
                },
                {
                    "data": "item_name"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "searchable": false
                }
            ],
            "language": {
                "emptyTable": "Loading data..."
            }
        });


        // পেজ লোডে ডিফল্ট ডাটা লোড
        loadData('');

        // সার্চ বাটন ক্লিক
        $('#search_btn').on('click', function() {
            let invoice_id = $('#invoice_id').val().trim();
            if (invoice_id === '') {
                alert('Please enter Invoice ID');
                $('#invoice_id').focus();
                return;
            }
            loadData(invoice_id);
        });

        // ইনপুট ফিল্ডে Enter প্রেস করলে সার্চ ট্রিগার
        $('#invoice_id').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#search_btn').click();
            }
        });

        function loadData(invoice_id = '') {
            let action = $('#frmSubmit').attr('action');

            $.ajax({
                url: action,
                method: 'POST',
                data: {
                    invoice_id: invoice_id,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    table.clear().draw();
                },
                success: function(data) {
                    console.log(data)
                    if (!data || data.length === 0) {
                        table.clear().draw();
                        alert("No records found");
                        return;
                    }

                    let formattedData = data.map((item, index) => {
                        return {
                            sl: index + 1,
                            invoice_code: item.invoice_code,
                            // invoice_no_pk: item.invoice_no_pk,
                            patient_code: item.patient_code,
                            gender_txt: item.gender_txt,
                            patient_photo: item.patient_photo,
                            patient_name: item.patient_name,
                            serviceunit_name: item.serviceunit_name,
                            item_name: item.item_name,
                            action: `<a href="{{ url('delivery/radiology-label-print') }}/${item.radinvoicedtl_no_pk}" target="_blank" class="btn btn-sm btn-secondary text-black">Label</a>`
                        };
                    });

                    table.clear().rows.add(formattedData).draw();
                },
                error: function(xhr, status, error) {
                    alert("Something went wrong!");
                    console.error(error);
                }
            });
        }
    });
</script>
