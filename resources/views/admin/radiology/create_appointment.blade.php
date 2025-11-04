@php

    $app = isset($app) && !empty($app) ? $app : [];

    $radinvoicedtl_no_pk = $app ? $app->radinvoicedtl_no_pk : '';

@endphp

<!-- datepicker -->
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
    .bg-success {
        background-color: #28a745;
        /* Bootstrap green */
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom shadow-sm">
        <div class="col">
            <h5 class="mt-2 mb-0">Create Appointment</h5>
            <small>Radiology / Create Appointment</small>
        </div>
        <div class="col-8">
            <h4 class="text-danger float-right mt-2" style="font-family: emoji;">
              <div>Press Enter For Search</div>
              <div>Press F4 For Save Appointment</div>
            </h4>

        </div>
    </div>
    <div class="form-row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fa fa-search"></i>&nbsp; Search</h5>
                </div>
                <div class="card-body" style="min-height: 100px;">
                    <div class="form-row justify-content-center mt-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="invoice_code" class="col-form-label col-form-label-sm">Invoice ID <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="invoice_id"
                                    name="invoice_id" value="" placeholder="Enter Invoice ID" required>
                            </div>
                        </div>
                        {{-- <div class="col-md-4">
                            <div class="form-group">
                                <label for="invoice_code" class="col-form-label col-form-label-sm">Prescription
                                    No</label>
                                <input type="text" class="form-control form-control-sm" id="prescription_uid"
                                    name="prescription_uid" value="" placeholder="Prescription UID">
                                <input type="hidden" class="form-control" id="" name="" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-md btn-success mt-4 btn-md-global" id="searchRadiology"
                                onclick="searchRadiologyInfoByVouchar(this)"
                                data-action="{{ route('radiology.search-appointment') }}"> <i
                                    class="fa fa-search mr-1"></i> Search</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="patient_info">
            @include('admin.components.patient_info_rad')
        </div>
    </div>

    <div class="form-row">


        @include('admin.radiology.radiology_new_apointment_query')


    </div>



</div>
<!-- datepicker -->

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    $(function() {
        var date = new Date();
        date.setDate(date.getDate());

        $('.date_picker').datepicker({
            startDate: date,
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        $("#invoice_id").focus();
        $('.select2').select2();
    });


    $(document).ready(function() {
        $('#invoice_id').focus()
    });


    // $(document).on('input', '#invoice_id', function(thisElement) {
    //     $("#app_id").val($("#invoice_id").val())
    //     if (this.value.length == 16) {
    //         searchRadiologyInfoByVouchar()
    //         searchPatientInfo()
    //     }
    // });
    $(document).on('keydown', '#invoice_id', function(event) {
    if (event.key === 'Enter' || event.keyCode === 13) {
        $("#app_id").val($("#invoice_id").val());
        searchRadiologyInfoByVouchar();
        searchPatientInfo();
        event.preventDefault();
    }
});



    async function searchRadiologyInfoByVouchar() {
        const invoice_id = $("#invoice_id").val();
        if (!invoice_id) {
            showErrorModal("You did not give any Appointment Code");
            return;
        }

        try {
            blockUI();

            const appointmentData = await $.ajax({
                url: '{{ route('radiology.search-appointment') }}',
                type: "post",
                data: {
                    invoice_id
                }
            });

            const investigationData = await $.ajax({
                url: "{{ route('radiology.search-appointment-investigation') }}",
                type: "post",
                data: {
                    invoice_id
                }
            });

            $("#patient-radiology-container").html(investigationData);
            $('#invoice_id').val('');
            $('#invoice_idForm').val(invoice_id);

            // Rebind the event and trigger click on the first radio button
            $('#patient-radiology-container').on('change', 'tr.myTest input[type="radio"]', function() {
                get_add_que(this);
            });

            // Automatically click the first radio button if it exists
            const firstRadioButton = $('#patient-radiology-container').find('tr.myTest input[type="radio"]')
                .first();
            if (firstRadioButton.length) {
                firstRadioButton.prop('checked', true).trigger('change');
            }

        } catch (error) {
            showErrorModal("Failed to fetch data: " + error);
        } finally {
            $.unblockUI();
        }
    }



    // function get_add_que(element) {
    //     const value = $(element).data('s_id');
    //     $('#inv_voucher_no').val($(element).data('p_id'));

    //     $.ajax({
    //         url: "{{ route('radiology.get-room') }}",
    //         type: 'post',
    //         data: {
    //             id: value
    //         },
    //         success: function(data) {
    //             $('#search_data').html(data);
    //         },
    //         error: function() {
    //             alert('No Room Found.');
    //         }
    //     });
    // }



    async function searchPatientInfo() {
        const invoice_id = $("#invoice_id").val();
        const radio_appointment_date = $("#radio_appointment_date").val();

        if (!invoice_id) {
            showErrorModal("You did not give any Invoice ID");
            return;
        }

        try {
            blockUI();

            // Fetch patient info
            const patientData = await $.ajax({
                url: '{{ route('radiology.search-appointment-patient-data') }}',
                type: "post",
                data: {
                    invoice_id
                },
            });

            $("#patient_info").html(patientData);

            // Fetch schedule intervals
            // const intervalData = await $.ajax({
            //     url: "{{ route('schedule-intervals') }}",
            //     type: "get",
            //     data: {
            //         radio_appointment_date
            //     },
            // });

            // $("#interval_data").html(intervalData);
            // $('#total_slot').val('');

        } catch (error) {
            showErrorModal("No Data Found");
        } finally {
            $.unblockUI();
        }
    }


    async function get_add_que(element) {
        // Get the values from the element
        const value = $(element).data('s_id');
        const voucherNo = $(element).data('p_id');
        const radioAppointmentDate = $("#radio_appointment_date").val();

        // Set the voucher number in the input field
        $('#inv_voucher_no').val(voucherNo);

        // Remove 'bg-success' class from all rows
        $('tr.myTest').removeClass('bg-success');

        // Add 'bg-success' class to the closest <tr> of the selected element
        $(element).closest('tr').addClass('bg-success');

        try {
            // Fetch room data
            const roomResponse = await $.ajax({
                url: "{{ route('radiology.get-room') }}",
                type: 'POST',
                data: {
                    id: value
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Include CSRF token if needed
                }
            });

            // Update the search data with room response
            $('#search_data').html(roomResponse);

            // Fetch schedule intervals
            const intervalResponse = await $.ajax({
                url: "{{ route('schedule-intervals') }}",
                type: 'GET',
                data: {
                    radio_appointment_date: radioAppointmentDate,
                    dept_id: value,
                }
            });

            $("#interval_data").html(intervalResponse);
            $('#total_slot').val('');
            // Handle schedule intervals response if needed
            // For example, you could update some element with intervalResponse

        } catch (error) {
            // Handle errors with more detail if needed
            // alert('No Schedule Found In This room');
            console.error('No Data Found', error); // Log the error for debugging
        }
    }




    function showErrorModal(message) {
        $('.common-modal-notify-error').modal('show');
        $('.common-modal-notify-error .modal-title').html("Error");
        $('.common-modal-notify-error .modal-body').html(message);
    }
</script>
