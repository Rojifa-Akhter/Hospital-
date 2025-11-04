<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<style>
    .AutoScroll {
        color: #fff;
        position: relative;
        top: 0px;
        max-height: 750px;
        overflow-y: scroll;
    }

</style>


{{-- Api System --}}

<audio id="audio" controls="controls" hidden>
    <source id="audioSource" src="">
    </source>
    Your browser does not support the audio format.
</audio>



{{-- End --}}












<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm py-1">
        <div class="col-md-12">
            <div class="form-row align-items-center justify-content-between">
                <div class="col-md-6">
                    <h5 class="mb-0">Patient Queue</h5>
                    <small>Home / Patient Queue</small>
                </div>



                <div class="col-md-6 justify-content-end">
                    <div class="top-action d-flex align-items-center justify-content-end">
                        <div class="form-group" style="margin-bottom: 0px!important; margin-right: 5px;">
                            <span class="badge badge-primary" id="displayDiv"></span>

                            <select class="form-control " id="refresh_time" name="refresh_time"
                                style="margin-bottom: 0px!important;">
                                <option value="">Select Refresh Time</option>
                                <option value="1 min">1 min</option>
                                <option value="3 min">3 mins</option>
                                <option value="5 min">5 mins</option>
                                <option value="10 min">10 mins</option>
                            </select>
                        </div>
                        <button class="btn btn-outline-primary btn-md float-right open-modal mt-3" data-action=""
                            data-title="Dashboard Refresh"><i class="fa fa-sync"></i> Refresh</button>
                        <button class="btn btn-outline-success btn-md float-right mt-3 ml-1" id="button"
                            type="button"><i class="fa fa-play"></i> Play</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row" id="tv_screen_data_table">
        @include("admin.dashboards.tv_screen_data_table")
    </div>
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('js/autoscroll.js') }}"></script>

<script>
    $('.date_picker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $('.select2').select2({});
    $('.data-table').DataTable({});
    $(".AutoScroll").scroller();

    countDown(120);

    //screen data table reload

    function buttonClick() {
        alert("button was clicked");
    }
    window.onload = function() {
        document.getElementById("btn").click();
        alert('Page Loaded')
    };




    setInterval(function() {
        $.ajax({
            async: true,
            type: "POST",
            url: "{{ route('tv-screen-data-table') }}",
            dataType: 'html',
            beforeSend: function() {
                // blockUI();
            },
            success: function(result) {
                $('#tv_screen_data_table').html(result);
                countDown(i);
                voiceAlert();
                //$.unblockUI();
            },
            error: function(data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages).siblings("label").html();
                    error_messages += "<div class='alert alert-danger' role='alert'>" +
                        errors[messages] + "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                //$.unblockUI();
            }
        });

    }, 10000);


    function countDown(i) {
        var int = setInterval(function() {
            document.getElementById("displayDiv").innerHTML = "Count Down Time: " + i + " Second";
            i-- || clearInterval(int); //if i is 0, then stop the interval
        }, 1000);
    }



    function voiceAlert() {
        //e.preventDefault();
        // var my_text = document.getElementById("textareaID").value;
        // var audio = document.getElementById('audio');

        // var source = document.getElementById('audioSource');
        // source.src =
        //     "http://api.voicerss.org/?key=9e0c85125e694fb38fa306cb4a69f10c&hl=en-in&c=MP3&f=alaw_11khz_stereo&v=Ajit&src=" +
        //     my_text;

        // audio.load(); //call this to just preload the audio without playing
        // audio.play(); //call this to play the song right away
    }
</script>
