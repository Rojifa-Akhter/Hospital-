<style>
    input[type="file"] {
        line-height: 1.0 !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Uniform Request</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                            <div class="card shadow-sm rounded-lg">
                                <div class="card-body p-4">
                                    <div class="form-row mb-3">
                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <div class="form-group">
                                                <label for="billing_date" class="col-form-label font-weight-bold">Request Date<span style="color:red;">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="billing_date" name="billing_date"
                                                    placeholder="" value="{{ date('d/m/Y') }}" required readonly />
                                            </div>
                                        </div>
                            
                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <div class="form-group">
                                                <label for="req_by_person_no_fk" class="col-form-label font-weight-bold">Requested By</label>
                                                <input type="text" class="form-control form-control-sm" id="req_by_person_no_fk" name="req_by_person_no_fk" placeholder=""
                                                    value="{{ $requested_by_name->user_fullname }}" readonly />
                                                <input type="hidden" name="req_by_person_no_fk_hdn" id="req_by_person_no_fk_hdn" value="{{ $requested_by_name->person_no_pk }}">
                                            </div>
                                        </div>
                            
                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <div class="form-group">
                                                <label for="req_dept" class="col-form-label font-weight-bold">Department</label>
                                                <input type="text" class="form-control form-control-sm" id="req_dept" name="req_dept" placeholder=""
                                                    value="{{ $requested_by_name->serviceunit_name }}" readonly />
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="form-row">
                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <div class="form-group">
                                                <label for="req_desig" class="col-form-label font-weight-bold">Designation</label>
                                                <input type="text" class="form-control form-control-sm" id="req_desig" name="req_desig" placeholder=""
                                                    value="{{ $requested_by_name->designation_name }}" readonly />
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12 ">
                                            <div class="form-group">
                                                <label for="year" class="col-form-label font-weight-bold">Year</label>
                                                <select class="form-control form-control-sm" id="year" name="year">
                                                    @php
                                                        $currentYear = date('Y'); // Get current year
                                                        $startYear = $currentYear - 2; // Previous 2 years
                                                        $endYear = $currentYear + 10; // Next 10 years
                                                    @endphp
                                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                                        <option value="{{ $year }}" @if ($year == $currentYear) selected @endif>
                                                            {{ $year }} 
                                                        </option>
                                                    @endfor
                                                </select> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg" id="table_head">
                                        <tr>
                                            <th>S/L</th>
                                            <th class="d-none">Item No PK</th>
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Allocated Qty</th>
                                            <th>Request Qty</th>
                                            <th>Request Date</th>
                                            <th>Issue Qty</th>
                                            <th>Issue Date</th>
                                            <th>Year</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-append-to3">
                                        @foreach($requestData as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td> <!-- Display S/L (Serial number) -->
                                                <td class="d-none">
                                                    <!-- Hidden Item No PK input field -->
                                                    <input type="hidden" name="item_no_pk[]" value="{{ $item->item_no_pk }}">
                                                </td>
                                                <td>{{ $item->item_code }}</td>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ $item->allocated_qty }}</td>
                                                <td>{{ $item->request_qty }}</td>
                                                <td>{{ $item->request_date }}</td>
                                                <td>{{ $item->issue_qty }}</td>
                                                <td>{{ $item->issue_date }}</td>
                                                <td>{{ $item->year }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm request-btn" data-item-code="{{ $item->item_code }}" 
                                                        data-item-name="{{ $item->item_name }}" 
                                                        data-allocated-qty="{{ $item->allocated_qty }}" 
                                                        data-item-no-pk="{{ $item->item_no_pk }}">Request</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="requestModal" tabindex="-1" aria-labelledby="requestModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="requestModalLabel">Request Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="requestForm">
                                    <div class="mb-3">
                                        <label for="item_code" class="form-label">Item Code</label>
                                        <input type="text" class="form-control" id="item_code" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="item_name" class="form-label">Item Name</label>
                                        <input type="text" class="form-control" id="item_name" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="size" class="form-label">Size</label>
                                        <select class="form-select" id="size" required>
                                            <option value="" disabled selected>Select Size</option>
                                            <option value="S">S</option>
                                            <option value="M">M</option>
                                            <option value="L">L</option>
                                            <option value="XL">XL</option>
                                            <option value="XXL">XXL</option>
                                            <option value="36">36</option>
                                            <option value="37">37</option>
                                            <option value="38">38</option>
                                            <option value="39">39</option>
                                            <option value="40">40</option>
                                            <option value="41">41</option>
                                            <option value="42">42</option>
                                            <option value="43">43</option>
                                            <option value="44">44</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="request_qty" class="form-label">Request Qty</label>
                                        <input type="number" class="form-control" id="request_qty" min="1" required readonly> 
                                    </div>
                                    <div class="mb-3">
                                        <label for="req_remarks" class="form-label">Request Remarks</label>
                                        <textarea class="form-control" id="req_remarks" rows="4" required> </textarea> <!-- Change input to textarea -->
                                    </div>
                                    <input type="hidden" id="item_no_pk" name="item_no_pk">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function(){
    $('#year').prop('disabled', true);
        });
        
    $(document).ready(function() {
    // When the "Request" button is clicked
    $('.request-btn').on('click', function() {
        var itemCode = $(this).data('item-code');
        var itemName = $(this).data('item-name');
        var allocatedQty = $(this).data('allocated-qty');
        var requestedQty = $(this).closest('tr').find('td').eq(5).text(); 
        var itemNoPk = $(this).data('item-no-pk');

        if (allocatedQty == requestedQty) {
            alert('Already Requested: The item has already been requested. You cannot request it again.');
            return; 
        }

        
        $('#item_code').val(itemCode);
        $('#item_name').val(itemName);
        $('#item_no_pk').val(itemNoPk);
        $('#request_qty').attr('max', allocatedQty);
        $('#request_qty').val(Math.min(allocatedQty));

        // Show the modal
        $('#requestModal').modal('show');
    });

    $('#requestForm').on('submit', function(e) {
    e.preventDefault();  // Prevent the default form submission

    // Collect form data
    var itemNoPk = $('#item_no_pk').val();
    var requestQty = $('#request_qty').val();
    var reqDesig = $('#req_desig').val(); 
    var reqPersonNo = $('#req_by_person_no_fk_hdn').val(); //req_by_person_no_fk_hdn
    var year = $('#year').val();
    var allocatedQty = $(this).data('allocated-qty'); 
    var reqRemarks = $('#req_remarks').val();// Get allocated quantity from data attribute
    var reqSize = $('#size').val();
    var csrfToken = $('meta[name="csrf-token"]').attr('content');  // Get the CSRF token from meta tag

    // Validation check (for example, ensure request quantity is less than or equal to allocated quantity)
    if (parseInt(requestQty) > parseInt(allocatedQty)) {
        alert("Request quantity exceeds allocated quantity.");
        return;  // Exit if validation fails
    }

    // Prepare form data object to send in the request
    var formData = {
        item_no_pk: itemNoPk,
        request_qty: requestQty,
        req_desig: reqDesig,
        req_size: reqSize,
        year: year,
        req_person_no : reqPersonNo,
        req_remarks : reqRemarks,
        allocated_qty: allocatedQty,
        _token: csrfToken  // Include CSRF token for security
    };

    // Make the AJAX request to submit the form
    $.ajax({
        url: "{{ route('uniform-request-store') }}",  // The route to the controller
        method: 'POST',  // POST request method
        data: formData,  // Send the form data
        success: function(response) {
            // Check if the response indicates success
            if (response.success) {
                $('#requestModal').modal('hide');  // Close the modal on success
                alert('Request Submitted Successfully!');  // Display success message
                location.reload();
            } else {
                alert('Error: ' + response.message);  // Display failure message if success is false
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX error
            alert('Error submitting request! Please try again.');
        }
    });
});

    /*
    $('#requestForm').on('submit', function(e) {
        e.preventDefault();

        var itemNoPk = $('#item_no_pk').val();
        var requestQty = $('#request_qty').val();
        var reqDesig = $('#req_desig').val(); 
        var year = $('#year').val(); 
        var allocatedQty = $(this).data('allocated-qty');
        var csrfToken = $('meta[name="csrf-token"]').attr('content'); 
        var formData = {
            item_no_pk: itemNoPk,
            request_qty: requestQty,
            req_desig: reqDesig, 
            year: year,
            allocated_qty : allocatedQty,
            _token: csrfToken 
        };



        // Make the AJAX request
        $.ajax({
            url: "{{ route('uniform-request-store') }}", 
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#requestModal').modal('hide');
                alert('Request Submitted Successfully!');
                
            },
            error: function(xhr, status, error) {
                alert('Error submitting request! Please try again.');
            }
        });
    });

    */
});


</script>
{{-- <script>
    openDoctorAutocomplete('#person_no_fk', 'emp_id', "employee_ind", 1, personInfo);

    function personInfo(item, obj) {
        $("#designation").val(item.designation);
        $("#department").val(item.su_name);
        $("#person_no_fkhdn").val(item.doctor_id);
    }

    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).ready(function() {
        $('.select2').select2();
    });

    $('#type_name').on('change', function() {
        var type_value = $(this).val();
        $.ajax({
            type: "GET",
            data: {
                'type_value': type_value
            },
            url: "{{ route('urgent-trasport') }}",
            success: function(data) {
                $('#select_transport').empty();
                $.each(data, function(key, value) {
                    $('#select_transport').append($('<option>', {
                        value: key,
                        text: value
                    }));
                });
            },
        });
    });


    calculateTotalAndSerialNumbers();

    $('.amount').on('keyup', function() {
        calculateTotalAndSerialNumbers();

        $('.amount').each(function(index, currentElement) {
            var sl_no = index + 2;
            $(currentElement).parents('tr').find('.serial-number').val('Trip' + '-' + sl_no);
        });
    });

    function calculateTotalAndSerialNumbers() {
        var am = 0;
        $('.amount').each(function(index, currentElement) {
            am += $(this).val() != "" ? parseFloat($(this).val()) : 0;
        });
        $('#total_bill_amount').val(am);
    }

    function addRow3(thisElement) {
        var date_val = $("#ddd").val();
        var amount_val = $("#aaa").val();
        if (date_val === "" && amount_val === "") {
            alert("Please fill in date and amount!");
            return;
        }
        if (date_val === "") {
            alert("Please fill in date!");
            return;
        }
        if (amount_val === "") {
            alert("Please fill in amount!");
            return;
        }

        var am = 0;
        $('.amount').each(function(index, currentElement) {
            am += parseFloat($(this).val());
            $('#total_bill_amount').val(am);
            $(currentElement).parents('tr').find('.serial-number').val(index + 2);
        });

        var parentRow = $(thisElement).parents("tr");
        var newRow = parentRow.clone();
        var newRowId = $(thisElement).parents("#data-append-to3").find("tr").length + 1;

        newRow.attr("id", newRowId);
        newRow.find("[class^='remove_']").attr("class", "remove_" + newRowId);

        newRow.find(".remove_" + newRowId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'><i class='fa fa-times'></i></span>"
        );

        var select_transport = parentRow.find("#select_transport").val();
        var select_from = parentRow.find("#select_from").val();
        var select_to = parentRow.find("#select_to").val();
        var select_purpose = parentRow.find("#select_purpose").val();
        // serialNumber++;

        // newRow.find("#trip_id").val(serialNumber);

        parentRow.find("input[type='text']").val('');
        parentRow.find("input[type='number']").val(null);
        parentRow.find("input[type='file']").val(null);
        // parentRow.find("select").val('');


        // parentRow.after(newRow);
        $('#data-append-to3').append(newRow);
        $('.serial-number').each(function(index, sl) {
            var sl_no = index++;
            $(sl).val('Trip' + '-' + sl_no);
        });
        newRow.find("#select_transport").val(select_transport);
        newRow.find("#select_from").val(select_from);
        newRow.find("#select_to").val(select_to);
        newRow.find("#select_purpose").val(select_purpose);

        newRow.find(".date_picker").datepicker();
    }

    function removeTableRowOnly(thisElement) {
        var row = $(thisElement).parents("tr");
        row.remove();
        var am = 0;
        $('.amount').each(function(index, currentElement) {
            am += $(this).val() != "" ? parseFloat($(this).val()) : 0;
            // console.log(am, $(this).val());
            $('#total_bill_amount').val(am);
            var sl_no = index++;
            $(currentElement).parents('tr').find('.serial-number').val('Trip' + '-' + sl_no);
        });

    }

     $('#save_btn').click(function() {
        var trip_date = $("#table_head tr:nth-child(2)").find('.date_picker').val();
        console.log(trip_date);
        var check_record = $("#data-append-to3 tr").length;
        // console.log(check_record);
        if (check_record > 0 && trip_date == '') {
            // btnSaveUpdate($('#save_btn'), '', '', '', '', search_list);
            btnSaveUpdateUpload($('#save_btn'), '', '', '', '', dynamicFunc.afterSaveLoadPage, "{{route('conveyance-bill-worklist')}}");
        } else {
            alert("Please enter data")
        }
    })


</script> --}}
