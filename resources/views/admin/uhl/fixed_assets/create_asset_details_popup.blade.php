  <!-- Modal- Transfer-->
  <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

  <form action="{{route('v1.save_details')}}" method="post" id="createDetails" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="item_no" value="{{ !empty($photo_name) ? $photo_name->item_no_pk : '' }}">

      {{-- Transfer To start--}}
      <div class="form-row">
          <div class="col-md-4">
              <span class="upload__heading">Upload Image</span>
              <div class="form-group">
                  <div class="upload__img__box">

                      <div class="avatar-upload">
                          <div class="avatar-edit">
                              <input type="file" id="imageUpload" name="item_photo" accept=".png, .jpg, .jpeg" value="{{ !empty($photo_name) ? $photo_name->item_photo : '' }}">

                              <label for="imageUpload"></label>

                          </div>

                          <div class="avatar-preview">

                              @if (!empty($photo_name))
                              @php
                              $imgUrl = '../images/uploads/item_images/thumb/' . $photo_name->item_photo;
                              @endphp
                              <div id="imagePreview" style="background-image: url('{{ $imgUrl }}');">
                              </div>
                              @else
                              <div id="imagePreview" style="background-image: url('../public/images/doc-1.png');">
                              </div>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-md-8">
              <div class="form-row">
                  <div class="col-md-12">
                      <div class="card_box">
                          <div class="">
                            <p class="mb-2">Current Location: <span style="font-weight: bold">{{$asset_register_data->room_name}} [{{$asset_register_data->physicalstruct_name}}]</span></p>
                            <p class="mb-2">Free Support Date: <span style="font-weight: bold">{{$asset_register_data->free_support_date ? date('d-m-Y', strtotime($asset_register_data->free_support_date)) : "N/A"}}</span></p>
                            <p class="mb-2">License Number: <span style="font-weight: bold">{{$asset_register_data->licenance_number ? $asset_register_data->licenance_number : "N/A"}}</span></p>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12">
                      <div class="card_box">
                          <div class="">
                              <p class="mb-2">Maintenance Engineer Name: <span style="font-weight: bold">{{$asset_register_data->assign_engr_name ? $asset_register_data->assign_engr_name : "N/A"}}</span></p>
                              <p class="mb-2">Maintenance Engineer Contact: <span style="font-weight: bold">{{$asset_register_data->maintanance_engr_contact ? $asset_register_data->maintanance_engr_contact : "N/A"}}</span></p>
                              <p class="mb-2">Last Maintenance Date: <span style="font-weight: bold">{{$asset_register_data->maintanance_date ? date('d-m-Y', strtotime($asset_register_data->maintanance_date)) : "N/A"}}</span></p>
                              <p class="mb-2">Next Maintenance Date: <span style="font-weight: bold">{{$asset_register_data->next_maintanance_date ? date('d-m-Y', strtotime($asset_register_data->next_maintanance_date)) : "N/A"}}</span></p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      @php
      $redirect_url=route('v1.asset-register');

      @endphp
      {{-- Transfer To end--}}
      <button type="submit" class="btn btn-primary uhl_save_btn" id="save_update" data-func="">Save Image</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
  </form>
  <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
  <script>
      openDoctorAutocomplete('#person_in', 'hdn_person_id', 'employee_ind', '1', department);

      function department(item, obj) {
          $('#department').html(item.su_name);
      }
      $(document).on("click", '#save_update', function(e) {
          if (confirm("Are you sure?")) {

              $('#createDetails').unbind().submit(function(e) {
                  e.preventDefault();

                  var formAction = $(this).attr("action");
                  var formMethod = $(this).attr("method");
                  var formData = new FormData(this);
                  var customFunc = $("#save_update").attr("data-func");

                  $.ajax({
                      type: formMethod,
                      url: formAction,
                      data: formData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      beforeSend: function() {
                          if (customFunc == "") {
                              if (isAModalOpen)
                                  $('.modal').modal('hide');


                          }
                          blockUI();
                      },
                      success: function(data) {

                        if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                      },

                      complete: function() {
                          $.unblockUI();
                          assetsSearchFunc();
                      },
                      error: function(data) {
                          var errors = jQuery.parseJSON(data.responseText).msg;

                          error_messages = "";
                          for (messages in errors) {
                              var field_name = $("#" + messages).siblings("label")
                                  .html();
                              error_messages +=
                                  "<div class='alert alert-danger' role='alert'>" +
                                  errors[messages] + "</div>";
                          }
                          $('.common-modal-notify-error').modal('show');
                          $('.common-modal-notify-error .modal-title').html(
                              "Validation Error");
                          $('.common-modal-notify-error .modal-body').html(
                              errors);
                          finished = false;
                          $.unblockUI();
                      }
                  });
              });
              e.stopImmediatePropagation();
          }else {

            return false;
          }
      });

      function readURL(input) {
          if (input.files && input.files[0]) {

              var reader = new FileReader();
              reader.onload = function(e) {
                  $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                  $('#imagePreview').hide();
                  $('#imagePreview').fadeIn(650);
              }
              reader.readAsDataURL(input.files[0]);
          }
      }
      $("#imageUpload").change(function() {
          readURL(this);
      });
  </script>
