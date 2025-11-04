<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('css/select2-custom.css') }}" rel="stylesheet" />

<style>
    .select2-container .select2-dropdown {
        width: 400px;
    }

    .select2-selection__rendered {
        text-align: left;
    }

    .select2-results__option {
        font-size: 12px;
    }
</style>

<section class="medical_benefit">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-11">
                        <h5 class="mt-2 mb-0">Medical Benefit Setup</h5>
                        <small>Accounts / Medical Benefit Setup</small>
                    </div>
                </div>
            </div>
        </div>

        <form action="#" method="post" id="medicalBenefitSave" class="medicalBenefitSave">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 col-12">

                            <div class="form-group form-row">
                                <label for="benefit_type_no" class="col-4 col-form-label">
                                    Benefit Type <span style="color:#dc3545">*</span>
                                </label>
                                <div class="col-8">
                                    <select name="benefit_type_no" id="benefit_type_no"
                                            class="form-control form-control-sm select2" required>
                                        <option value="">Select Benefit Type</option>
                                        @foreach ($medical_benefit_type as $key => $name)
                                            <option value="{{ $key }}"
                                                {{ isset($data->benefit_tpye_no) && $data->benefit_tpye_no == $key ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="benefit_type_name" id="benefit_type_name"
                                        value="{{ $data->benefit_tpye_name ?? '' }}">
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="benefit_effective_at" class="col-sm-4 col-form-label">Effective Date <span
                                        style="color:#dc3545">*</span></label>
                                <div class="col-sm-8">
                                    <input type="date" class="form-control form-control-sm" id="benefit_effective_at"
                                        name="benefit_effective_at" required>
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="benefit_amount" class="col-sm-4 col-form-label">Benefit Amount <span
                                        style="color:#dc3545">*</span></label>
                                <div class="col-sm-8">
                                    <input type="number" step="0.01" class="form-control form-control-sm"
                                        id="benefit_amount" name="benefit_amount" placeholder="Enter Amount" required>
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="status" class="col-sm-4 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="status" id="status" class="form-control form-control-sm">
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group text-right mt-3">
                                <button type="button" class="btn btn-secondary uhl_save_btn"
                                    onclick="saveMedicalBenefitForm()">Save</button>
                            </div>

                        </div>

                        <div class="col-md-6 col-12">
                            {{-- Future additional fields here --}}
                        </div>

                    </div>
                </div>
            </div>
        </form>

        <div class="card mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover medical_benefit_table">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center">SL No</th>
                                <th class="text-center">Benefit Type</th>
                                <th class="text-center">Effective Date</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Created By</th>
                                <th class="text-center">Create Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    const medicalBenefitTypes = @json($medical_benefit_type);

    function updateBenefitTypeName() {
        const selectedKey = $('#benefit_type_no').val();
        $('#benefit_type_name').val(medicalBenefitTypes[selectedKey] || '');
    }

    $('#benefit_type_no').on('change', updateBenefitTypeName);

    $(document).ready(function() {
        updateBenefitTypeName();
    });
</script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#benefit_type_no').select2({
        placeholder: "Select Benefit Type",
        allowClear: true
    });


    $(document).on('click', '#updateMedicalBenefitForm button[type="submit"]', function(e) {
        e.preventDefault();

        const form = $('#updateMedicalBenefitForm');

        if (form.valid()) {
            handleUpdateFormSubmission(form[0]);
        }
    });

    function handleUpdateFormSubmission(formElement) {
        let formData = new FormData(formElement);

        $.ajax({
            url: $(formElement).attr('action'),
            type: 'POST',
            headers: {
                'Accept': 'application/json'
            },
            data: formData,
            contentType: false,
            processData: false,

            beforeSend: function() {
                blockUI();
            },

            success: function(response) {
                $.unblockUI();

                if (response.status) {
                    $('.modal').modal('hide');

                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html(response.message);

                    getChequeData();
                }
            },

            error: function(xhr) {
                $.unblockUI();
                const error = xhr.responseJSON;

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(
                    error.message || "Something went wrong"
                );
            }
        });
    }


    // DataTable initialization
    const table = $('.medical_benefit_table').DataTable({
        searching: true,
        lengthMenu: [
            [25, 50, 75, 100, -1],
            [25, 50, 75, 100, "All"]
        ],
        pageLength: 25,
        columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6, 7],
                className: 'text-center'
            },
            {
                targets: [1],
                className: 'text-left'
            }
        ],
        initComplete: function() {
            $('th').addClass('text-center');
        }
    });

    // Fetch Medical Benefit Data
    function getMedicalBenefitData() {
        $.ajax({
            url: "{{ route('v1.get-medical-benefit') }}",
            method: "get",
            success: function(response) {
                if (response.data && response.data.length) {
                    setTableData(response.data);
                } else {
                    emptyTable();
                }
            },
            error: function(err) {
                const error = err.responseJSON || {};
                showErrorModal(error.message || 'Something went wrong.');
            }
        });
    }

    // Save Form Data
    window.saveMedicalBenefitForm = function() {
        const form = $('#medicalBenefitSave')[0];
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);

        $.ajax({
            url: "{{ route('v1.save-medical-benefit') }}",
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: blockUI,
            success: function(response) {
                $.unblockUI();
                if (response.status) {
                    getMedicalBenefitData();
                    form.reset();
                    $('#benefit_type_no').val('').trigger('change');
                    showSuccessModal(response.message || 'Saved successfully.');
                }
            },
            error: function(xhr) {
                $.unblockUI();
                const error = xhr.responseJSON || {};
                showErrorModal(error.message || 'Something went wrong.');
            }
        });
    };

    // Render Table Rows
    function setTableData(data) {
        const rows = data.map((item, i) => {
            const status = item.status == 1 ?
                '<span class="badge badge-success">Active</span>' :
                '<span class="badge badge-secondary">Inactive</span>';

            const editUrl = "{{ url('v1/edit-medical-benefit') }}/" + item.medical_benefit_no_pk;
            const effectiveDate = item.benefit_effective_at ? item.benefit_effective_at.split(' ')[0] : 'N/A';


            return [
                i + 1,
                item.benefit_type_name || 'N/A',
                effectiveDate || 'N/A',
                item.benefit_amount || '0',
                item.created_by_name || 'N/A',
                item.au_entry_at || 'N/A',
                status,
                `<button type="button" class="btn btn-sm btn-success open-modal"
                    data-action="${editUrl}"
                    data-modal="common-modal-sm"
                    data-title="Edit Medical Benefit"
                    title="Edit"
                    data-id="${item.medical_benefit_no_pk}">
                    <i class="fas fa-edit"></i>
                </button>`
            ];
        });

        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.medical_benefit_table tbody').html(`
            <tr>
                <td colspan="8" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }

    // Common Modal Helpers
    function showSuccessModal(message) {
        $('.common-modal-notify').modal('show');
        $('.common-modal-notify .modal-title').html("Success");
        $('.common-modal-notify .modal-body').html(message);
    }

    function showErrorModal(message) {
        $('.common-modal-notify-error').modal('show');
        $('.common-modal-notify-error .modal-title').html("Failed");
        $('.common-modal-notify-error .modal-body').html(message);
    }

    // Initial Load
    getMedicalBenefitData();
</script>
