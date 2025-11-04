<style>
    .accordion_title {
        position: relative;
    }

    .accordion_title i {
        position: absolute;
        top: 50%;
        right: 2%;
        transform: translateY(-50%);
        font-size: 18px;
        transition: all 0.3s;
    }
    #video{
        margin: 0 auto;
    }
    #imageprev{
        width:150;
        height:150;
    }
</style>


<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{asset('asset/timepicker/css/timepicker.css')}}">
<section id="add_doctor">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Patient Video Call</h5>
                <small>Prescription / Patient Video Call </small>
            </div>
        </div>
        <div class="card">

            <div class="card-body" >
                <div style="text-align: center;">
{{--                    <h3 >Khwaja Badrudduja Modern hospital</h3>--}}

                    <strong>
                        <?php
                        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                        echo $dt->format('d-F-Y, g:i a');

                        ?>

                    </strong>
                </div>
                <div style="text-align: center;">
                    <div id="video"></div>
                </div>
                <form method="post" id="frmsave" action=""  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="service_id" name="service_id" value="">
                    <div class="form-row"  >
                        <div id="attendance_data" class="col-md-8" id="emp_data">
                            @include('admin.prescription.video_cl_data_save')
                        </div>
                        <div class="col-md-4" >

                            <div id="canvas" class="mt-3"></div>
                        </div>
                    </div>


            </div>
            </form>

        </div>
    </div>
    </div>
</section>

<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{asset('asset/timepicker/js/timepicker.js')}}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/webcam.min.js') }}"></script>
<script>
    $(function() {
        $('#user_id').focus();
        Webcam.set({
            width: 340,
            height: 280,
            image_format: 'jpeg',
            jpeg_quality: 90,
            force_flash: false
        });
        Webcam.attach( '#video' );

        // $(document).on("keypress", "#user_id", function(e) {
        // 	if (e.keyCode === 13) {
        // 		event.preventDefault();
        // 	}

        // });

        Webcam.on( 'live', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        } );


        navigator.getMedia = ( navigator.getUserMedia ||  navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

        navigator.getMedia({video: true}, function() {


            $(document).on("keypress", "#user_id", function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();


                    Webcam.snap( function(data_uri) {
                        document.getElementById('canvas').innerHTML = '<img id="imageprev" width="150" src="'+data_uri+'"/>';
                        // var route_name = '{{ route("attendance_image_save")}}';

                        var service_number = $("#user_id").val();
                        var base64image = document.getElementById("imageprev").src;
                        var route_name = '{{ route("attendance_image_save")}}/'+service_number ;

                        Webcam.upload( base64image, route_name, function(code, text) {
                            if (text != "") {
                                var obj  = JSON.parse(text);

                                if(obj.full_name != ""){
                                    $("#emp_name").val(obj.full_name);
                                    $("#emp_designation").val(obj.designation_name);
                                    $("#emp_department").val(obj.serviceunit_name);


                                    var photo_route = "../public/images/uploads/doctor_images/"+obj.photo_name;

                                    $("#emp_photo").attr("src", photo_route);
                                    $("#user_id").val('');
                                }
                            }
                            $.unblockUI();
                        });

                    });
                }


                //
                $(this).focus();
                e.stopImmediatePropagation();
            });
        }, function() {


            $(document).on("keypress", "#user_id", function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();



                    var service_number = $("#user_id").val();

                    var route_name = '{{ route("attendance_save_machine")}}/'+service_number ;


                    $.ajax({
                        data: {service_number : service_number},
                        url:route_name,
                        type: "POST",
                        beforeSend: function() {
                            blockUI();

                        },
                        success: function(data) {

                            if (data !="") {

                                var obj  = JSON.parse(data);
                                if(obj.full_name != ""){
                                    $("#emp_name").val(obj.full_name);
                                    $("#emp_designation").val(obj.designation_name);
                                    $("#emp_department").val(obj.serviceunit_name);


                                    var photo_route = "../public/images/uploads/doctor_images/"+obj.photo_name;

                                    $("#emp_photo").attr("src", photo_route);
                                    $("#user_id").val('');
                                }
                            }
                            $.unblockUI();
                        },
                        complete: function() {
                            $.unblockUI();
                        }
                    });


                    //(obj);
                    //alert(obj.full_name);




                }


                //
                $(this).focus();
                e.stopImmediatePropagation();
            });
        });

    });
</script>
