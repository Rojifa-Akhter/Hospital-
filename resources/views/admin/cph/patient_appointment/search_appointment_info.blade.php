<form action="{{ route("patient_appointment_save_cph") }}" method="post" id="cph_patient_appointment_save" enctype="multipart/form-data">
<div class="row">
    <div class="col-md-3 col-sm-12">
            <img src="https://t4.ftcdn.net/jpg/02/60/78/83/360_F_260788352_x5sSHM4DGvpjHj9wz8sFltzAPktQwJCj.jpg" width="150px" alt="">
    </div>

    <div class="col-md-5 col-sm-12">
        <table width="100%" >
            <tbody class="pat_info">
            <tr>
                <td style="width: 250px;">Appointment Queue Date</td>
                <td style=""><input type="text" class="form-control" value="06/02/2024"></td>               
            </tr>
            <tr>
                <td> BP No.</td>
                <td><input type="text" class="form-control" value="258963"></td>               
            </tr>
            <tr>
                <td> Name</td>
                <td> <input type="text" class="form-control" value="Jamil Islam"></td>                
            </tr>
            <tr>
                <td> Rank</td>
                <td><input type="text" class="form-control" value="ASI"></td>
            </tr>
        </tbody>
        </table>
        {{-- <div class="form-group form-row mt-2">
            <label for="year" class="col-form-label col-form-label-sm">Appointment Queue Date</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="06/02/2024">
            </div>
        </div>

        <div class="form-group form-row mt-2">
            <label for="year" class="col-form-label col-form-label-sm mr-5">BP No.</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="258963">
            </div>
        </div>
        <div class="form-group form-row mt-2">
            <label for="year" class="col-form-label col-form-label-sm mr-5">Name</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="Imam Hosen">
            </div>
        </div>
        <div class="form-group form-row mt-2">
            <label for="year" class="col-form-label col-form-label-sm" style="margin-right: 54px;">Rank</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="ASI">
            </div>
        </div> --}}
    </div>
</div>

{{-- <div class="form-group form-row">
    <div class="col-md-2"></div>
    <label for="year" class="col-form-label col-form-label-sm" style="margin-right: 50px;">Appointment Queue Date</label>
    <div class="col-md-2">
        <input type="text" class="form-control" value="06/02/2024">
    </div>
</div> --}}

{{-- <div class="row mt-3">
    <div class="col-2">
        <img src="https://t4.ftcdn.net/jpg/02/60/78/83/360_F_260788352_x5sSHM4DGvpjHj9wz8sFltzAPktQwJCj.jpg" width="150px" alt="">
    </div>
    <div class="col-8">
        <div class="form-group form-row mt-2">
            <label for="year" class="col-form-label col-form-label-sm mr-5">BP No.</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="258963">
            </div>
        </div>
        <div class="form-group form-row mt-2">
            <label for="year" class="col-form-label col-form-label-sm mr-5">Name</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="Imam Hosen">
            </div>
        </div>
        <div class="form-group form-row mt-2">
            <label for="year" class="col-form-label col-form-label-sm" style="margin-right: 54px;">Rank</label>
            <div class="col-md-4">
                <input type="text" class="form-control" value="ASI">
            </div>
        </div>
    </div>
</div> --}}

<div class="mt-3">
    <table class="table table-striped table-bordered table-hover">
        <thead class="">
            <tr>
                <th>SL</th>
                <th class="text-center">Patient ID</th>
                <th class="text-left">Relation</th>
                <th class="text-left">Name</th>
                <th class="text-center">Age</th>
                <th class="text-center">Gender</th>
                <th class="text-center">Department</th>
                <th class="text-center">Room</th>
            </tr>
        </thead>
        <tbody id="">
            <tr>
                <td>1</td>
                <td class="text-center">AB8787</td>
                <td class="text-left">Father</td>
                <td class="text-left">Karim Khan</td>
                <td class="text-center">65</td>
                <td class="text-center">Male</td>
                <td class="text-center">
                    <select class="form-control form-control-sm" name="department" id="department">
                        <option value="">Select</option>
                        <option value="">OPD</option>
                    </select>
                </td>
                <td class="text-center">
                    <select class="form-control form-control-sm" name="room_no" id="room_no">
                        <option value="">Select</option>
                        <option value="">210</option>
                        <option value="">310</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>1</td>
                <td class="text-center">AB8733</td>
                <td class="text-left">Mother</td>
                <td class="text-left">Nasrin Khan</td>
                <td class="text-center">65</td>
                <td class="text-center">Female</td>
                <td class="text-left">
                    <select class="form-control form-control-sm" name="department" id="department">
                        <option value="">Select</option>
                        <option value="">OPD</option>
                    </select>
                </td>
                <td class="text-center">
                    <select class="form-control form-control-sm" name="room_no" id="room_no">
                        <option value="">Select</option>
                        <option value="">210</option>
                        <option value="">310</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    @php
    // $response_action = route('patient_appointment_save_cph');
    $response_action = "";

    // $patient_id = '';
    // $response_url = route('patient-card', $patient_id);
    @endphp
  <div class="row">
    <div class="col-lg-12 col-md-12 col-12">
        <div class="form-group">
            <ul class="list-inline btn__box">
                <li class="list-inline-item mb-0 mt-0">
                    {{-- <a data-modal="common-modal" data-action="{{ route('queue_preview') }}" class="btn mb-1 btn-success btn-sm open-modal modal-sm"
                                        data-title="Queue">Save</a> --}}
                <button type="button" id="submit" data-modal="common-modal-sm" class="btn btn-success open-modal" data-action="{{ route('queue_preview') }}">Save</button>
                </li>
                <li class="list-inline-item"><button type="button" class="btn btn-info">New Queue</button></li>
            </ul>
        </div>
    </div>
</div>
</div>       
</form>


<script>

$(document).on('keydown', function(event) {
  if (event.keyCode === 115 ) {
    $("#submit").click();
    console.log('F4 pressed');
  }
});
//   function saveUpdate(element) {
//         event.preventDefault();
//         var formData = new FormData($('#cph_patient_appointment_save')[0]);
//         var formAction = $(element).parents("form").attr("action");
//         var formMethod = $(element).parents("form").attr("method");
//         var formID = $(element).parents("form").attr("id");
//         var customFunc = $("#save_update").attr("data-func");

//         if ($('#pat_age_y').val() != "" || $('#pat_age_m').val() != "" || $('#pat_age_d').val() != "") {
//             if (formValidation(formID) == false) {
//                 return;
//             }
//             if (confirm("Are you sure?")) {
//                 $.ajax({
//                     type: formMethod,
//                     url: formAction,
//                     data: formData,
//                     cache: false,
//                     contentType: false,
//                     processData: false,
//                     beforeSend: function() {
//                         if (customFunc == "") {
//                             if (isAModalOpen)
//                                 $('.modal').modal('hide');
//                             $('.common-modal-notify').modal('show');
//                             $('.common-modal-notify .modal-body').html(
//                                 "<i class='fas fa-stroopwafel fa-spin'></i>"
//                             );
//                         }
//                         blockUI();
//                     },
//                     success: (data) => {
//                         var response_url = $("#save_update").attr("data-response-url") + "/" + data.insert_id;
//                         dynamicFunc.afterSaveModal(response_url, "common-modal-sm", "Patient Card");
//                         $('#frm-pat-registration').find("input, textarea").not('.keep_me').val("");
//                         $('#frm-pat-registration').find("select").not('.keep_me').val("0");
//                     },
//                     error: function(data) {},
//                     complete: function() {
//                         // if (page_type == 'edit')
//                         //     dynamicFunc.afterSaveLoadList("{{ route('registration.loadList') }}");
//                         $.unblockUI();
//                     },
//                     error: function(data) {
//                         var errors = jQuery.parseJSON(data.responseText)
//                             .errors;
//                         error_messages = "";
//                         for (messages in errors) {
//                             var field_name = $("#" + messages).siblings(
//                                     "label")
//                                 .html();
//                             error_messages +=
//                                 "<div class='alert alert-danger' role='alert'>" +
//                                 errors[messages] + "</div>";
//                         }

//                         $('.common-modal-notify-error').modal('show');
//                         $('.common-modal-notify-error .modal-title').html("Validation Error");
//                         $('.common-modal-notify-error .modal-body').html(error_messages);
//                         finished = false;
//                         $.unblockUI();
//                     }
//                 });
//                 // });

//             }
//         } else {
//             alert('Enter Age');
//             return;
//         }
//         e.stopImmediatePropagation();
//     }

</script>