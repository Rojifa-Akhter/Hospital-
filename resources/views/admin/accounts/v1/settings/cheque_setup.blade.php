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

<section class="fixed_asset">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div
                    class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-11">
                        <h5 class="mt-2 mb-0">Cheque Setup</h5>
                        <small>Accounts / Cheque Setup</small>
                    </div>
                </div>
            </div>
        </div>

        <form action="#" method="post" id="chequeDataSave" class="chequeDataSave">
            @csrf

            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-6 col-12">

                            <div class="form-group form-row">
                                <label for="add_bank_account_select" class="col-4 col-form-label">Bank <span style="color: #dc3545;">*</span></label>
                                <div class="col-8">
                                    <select name="bank_name" id="add_bank_account_select" class="bank-account-select" required>
                                        <option value=""></option> 
                                        @foreach ($bankAccounts as $account)
                                            <option value="{{ $account->account_pk }}">{{ $account->account_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="cheque_start_number" class="col-sm-4 col-form-label">Cheque Start Number <span style="color: #dc3545;">*</span></label>
                                <div class="col-sm-8">
                                    <input 
                                        type="number" 
                                        class="form-control form-control-sm"
                                        id="cheque_start_number" name="cheque_start_number"
                                        placeholder="Cheque Start Number" 
                                        value="" 
                                    />
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="cheque_end_number" class="col-sm-4 col-form-label">Cheque end Number <span style="color: #dc3545;">*</span></label>
                                <div class="col-sm-8">
                                    <input 
                                        type="number" 
                                        class="form-control form-control-sm"
                                        id="cheque_end_number" 
                                        name="cheque_end_number"
                                        placeholder="Cheque end Number" 
                                        value="" 
                                    />
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <label for="status" class="col-sm-4 col-form-label">Status</label>
                                <div class="col-sm-8">
                                    <select name="status" id="status"
                                        class="form-control form-control-sm">
                                        <option value="1" {{ old('status', 2) == 1 ? 'selected' : '' }}>Issue</option>
                                        <option value="2" {{ old('status', 2) == 2 ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="text-align: right; margin-top: 1rem">
                                <button 
                                    type="button" 
                                    class="btn btn-secondary uhl_save_btn"
                                    onclick="chequeDataSaveForm()"
                                >
                                    Save
                                </button>
                            </div>

                        </div>

                        <div class="col-md-6 col-12">

                            {{-- other filed add here if needed --}}

                        </div>

                    </div>
                </div>
            </div>
              
        </form>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover cheque_data_v1">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-center">SL No</th>
                                <th class="text-center">Bank Name</th>
                                <th class="text-center">Cheque Start Number</th>
                                <th class="text-center">Cheque End NUmber</th>
                                <th class="text-center">Created by</th>
                                <th class="text-center">Create Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</section>

{{-- <script src="{{ asset('js/typeahead.bundle.js') }}"></script> --}}
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#add_bank_account_select').select2({
        placeholder: "Select Bank", 
        allowClear: true 
    });

    $.validator.addMethod("chequeRange", function(value, element) {
        const form = $(element).closest('form');
        const startInput = form.find('[name="cheque_start_number"]');
        const endInput = form.find('[name="cheque_end_number"]');
        
        const start = parseInt(startInput.val(), 10);
        const end = parseInt(endInput.val(), 10);
        
        return isNaN(start) || isNaN(end) || start <= end;
    }, "End number must be greater than or equal to start number.");

    const chequeValidationConfig = {
        rules: {
            bank_name: {
                required: true
            },
            cheque_start_number: {
                required: true,
                number: true
            },
            cheque_end_number: {
                required: true,
                number: true,
                chequeRange: true
            }
        },
        
        messages: {
            bank_name: {
                required: "Bank name is required"
            },
            cheque_start_number: {
                required: "Start number is required",
                number: "Must be a valid number"
            },
            cheque_end_number: {
                required: "End number is required",
                number: "Must be a valid number",
                chequeRange: "End number must be greater than or equal to start number"
            }
        },
        
        errorElement: "em",
        
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-hidden-accessible')) {
                element.next('.select2-container').find('.select2-selection').addClass('is-invalid');
                error.insertAfter(element.next('.select2-container'));
            } else {
                element.addClass("is-invalid");
                error.insertAfter(element);
            }
        },
        
        success: function(label, element) {
            const $element = $(element);

            if ($element.hasClass('select2-hidden-accessible')) {
                $element.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            } else {
                $element.removeClass("is-invalid");
            }

            label.remove();
        }
    };

    $("#chequeDataSave").validate(chequeValidationConfig);

    /**
     * TODO: Refactor this handler
     * Currently using MutationObserver as a workaround for dynamically loaded content.
     * Should be replaced with a dedicated edit cheque button handler that:
     * 1. Loads modal content via AJAX first
     * 2. Then initializes Select2 and validation on the fully loaded form elements
     * 3. Avoids the need for DOM observation and timeouts
     */
    $(document).on('shown.bs.modal', '#exampleModal', function(event) {
        const $modal = $(this);
        
        const observer = new MutationObserver(function(mutations) {
            const $bankSelect = $('#edit_bank_account_select');
            const $form = $('#updateChequeForm');
            
            if ($bankSelect.length && !$bankSelect.hasClass('select2-hidden-accessible')) {
                $bankSelect.select2({
                    placeholder: "Select Bank",
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $modal
                });
            }
            
            if ($form.length && !$form.data('validator')) {
                $form.validate(chequeValidationConfig);
            }
            
            if ($bankSelect.hasClass('select2-hidden-accessible') && $form.data('validator')) {
                observer.disconnect();
            }
        });
        
        observer.observe($modal[0], { 
            childList: true, 
            subtree: true,
            attributes: false,
            characterData: false 
        });
        
        setTimeout(() => observer.disconnect(), 5000);
    });
    
    $(document).on('change', '.bank-account-select', function(event) {
        $(this).valid();
    });

    $(document).on('click', '#updateChequeForm button[type="submit"]', function(e) {
        e.preventDefault();
        
        const form = $('#updateChequeForm');

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

    const table = $('.cheque_data_v1').DataTable({
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

    function getChequeData() {
        $.ajax({
            url: "{{ route('v1.accounts.get-cheque') }}",
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
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').text('Failed');
                $('.common-modal-notify-error .modal-body').text(error.message ||
                    'Something went wrong.');
            }
        });
    }

    window.chequeDataSaveForm = function() {
        
        if (!$('#chequeDataSave').valid()) {
            return;
        }

        const formData = new FormData(document.getElementById('chequeDataSave'));

        $.ajax({
            url: "{{ route('v1.accounts.save-cheque') }}",
            type: "POST",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            headers: {
                'Accept': 'application/json'
            },
            
            beforeSend: blockUI,
            
            success: function(response) {
                $.unblockUI();
                
                if (response.status) {
                    getChequeData();
                    
                    $('#chequeDataSave')[0].reset();
                    $('#bank_name').val('').trigger('change'); 
                    
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html(response.message || 'Saved successfully.');
                }
            },
            
            error: function(xhr) {
                $.unblockUI();
                
                const error = xhr.responseJSON || {};
                
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(
                    error.message || 'Something went wrong.'
                );
            }
        });
    };

    function setTableData(data) {
        const rows = data.map((item, i) => {
            const status = (item.status == '1') 
                ? '<span class="badge badge-success">Issue</span>' 
                : '<span class="badge badge-secondary">Draft</span>';

            const editUrl = "{{ url('v1/accounts/edit-cheque') }}/" + item.checque_verified_no_pk;

            return [
                i + 1,
                item.bank_name || 'N/A',
                item.checque_no,
                item.checque_no_to,
                item.verified_by_name || 'N/A',
                item.checque_verified_date,
                status,
                `<button type="button" class="btn btn-sm btn-success btn-md-global open-modal btnView"
                    data-action="${editUrl}"
                    data-modal="common-modal-sm"
                    data-title="Edit Cheque Entry"
                    title="Edit"
                    data-id="${item.checque_verified_no_pk}">
                    <i class="fas fa-edit"></i>
                </button>`
            ];
        });

        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.cheque_data_v1 tbody').html(`
        <tr>
        <td colspan="8" class="text-danger text-center">Data Not Found</td>
        </tr>`);
    }

    getChequeData();

</script>
