<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TV</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" media="all">

    <!-- Pusher JS -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.min.js"></script> --}}

    <style>
        .doctor-bg {
            background-color: #0613d3;
        }
        .doctor-bg-2 {
            background-color: #2046fa;
        }
        .row {
            margin: 0 !important;
        }
        .card {
            border: 0 !important;
            background-color: unset !important;
        }
        .card-header {
            border-radius: 0 !important;
        }
        td, th {
            border: 1px solid white !important;
            font-weight: 500;
        }
        th {
            background-color: #2a3f7e;
            color: white;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #b2c8f7 ;
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #8bb7ff ;
        }
        .next_in_queue{
            background-color: yellow !important;
            color: black !important;
        }
        .time_over{
            background-color: red !important;
            color:white !important;
        }
    </style>
</head>
<body>

    <div class="row" id="tv_screen_show">
        
    </div>

    <script>
        Pusher.logToConsole = true;
        
        // Initialize Pusher and Echo
        var pusher = new Pusher('08b2100d4e81edeabd10', {
        cluster: 'mt1',
        forceTLS: true,
	enabledTransports: ['ws'],
    });

    var channel = pusher.subscribe('TVUpdate');
    

    // Listen to the TVUpdate event
    channel.bind('TVUpdate', function(event) {
        dataShow(event);
        
    });

    // Log any errors
    channel.bind('pusher:error', function(error) {
        console.log('Error with Pusher:', error);
    });

    function dataShow(temp){
       var  data = temp.data;
        var status = '';
        let urlParams = new URLSearchParams(window.location.search);
        let tvValue = urlParams.get('tv');
        let tbl = ``;
        let newRow = ``;
        let doctor_bg = 'doctor-bg';
        let time_over = '';
        let next_in_queue_index = 0;
        let next_in_queue = 'next_in_queue';
        let count = 0;
        if(data.length >= 1){
             count = data.filter(item => item.tvscreen_code == tvValue).length;
        }
        if(count == 0){
            $("#tv_screen_show").html(`<div class="col-12"><h2 class="text-center text-danger" style="margin-top:48vh">Data Not Found!</h2></div>`);
            return false;
        }
        let cols = 3;
        if(count == 1){
            cols = 12;
        }
        else if(count == 2){
            cols = 6;
        }
        else if(count == 3){
            cols = 4;
        }else if(count == 4){
            cols = 3;
        }else{
            cols = 3;
        }
        $("#tv_screen_show").html(``);
        data.forEach((row,index) => {
            if(row.tvscreen_code == tvValue){
                doctor_bg = index % 2 == 0 ? "doctor-bg" : "doctor-bg-2";
                tbl = ``;
                newRow = ``;
                next_in_queue_index = 0;
                next_in_queue = 'next_in_queue';
                time_over = '';
                row.patient.forEach((item, index2) => {
                    if(item.movement_type_no == 1){
                        status = 'Waiting';
                    }
                    else if(item.movement_type_no == 2){
                        status = 'To Consult';
                        next_in_queue = 'bg-success';
                    }
                    else if(item.movement_type_no == 3){
                        status = 'Completed';
                    }


                    if(item.end_time != null){
                        let currentTime = new Date();
                        let timeArray = item.end_time.split(":"); 
                        let hour = parseInt(timeArray[0]);
                        let minute = parseInt(timeArray[1]);
                        let second = parseInt(timeArray[2]);

                        timeParts = item.end_time.split(" "); 
                        if (timeParts[1] === "PM" && hour !== 12) {
                            hour += 12;
                        } else if (timeParts[1] === "AM" && hour === 12) {
                            hour = 0;
                        }

                        let targetTime = new Date();
                        targetTime.setHours(hour, minute, second);

                        if (currentTime >= targetTime) {
                            time_over = 'time_over';
                        } else {
                            time_over = ''; 
                        }
                    }else{
                        time_over = ''; 
                    }
                    

                    if(Number(row.patient.length) == 1 && Number(item.movement_type_no) == 2){
                        next_in_queue_index = 0 ;
                        
                    }
                    else if(Number(row.patient.length) == 1 && Number(item.movement_type_no) == 1){
                        next_in_queue_index = 0 ;
                        status = 'Next In Queue';
                    }

                    
                    if((Number(index2) == 1 &&  Number(row.patient[0].movement_type_no) == 2)){
                        next_in_queue_index = 1 ;
                        status = 'Next In Queue';
                        next_in_queue = 'next_in_queue';
                    }






                    newRow+= `
                        <tr class="${next_in_queue_index == index2 ? next_in_queue : time_over}">
                            <td>${item.patient_no_fk}(${item.pat_name})</td>
                            <td style="white-space:nowrap">${item.start_time}-${item.end_time}</td>
                            <td>${(next_in_queue_index == index2 && next_in_queue != 'bg-success') ? 'Next In Queue' : status}</td>
                        </tr>
                    `;
   
                })  
                
                


                
                tbl = `<div class="col-md-${cols} col-12 p-0 m-0">
                                <div class="card">
                                    <div class="card-header ${doctor_bg} text-white text-uppercase">
                                        
                                        <div style="display:flex;justify-content:space-between">
                                            <div>${row.doctor_name}</div>
                                            <div>(${row.patient.length})</div>
                                        </div>
                                    </div>
                                    <div class="card-body p-1">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>UHID(NAME)</th>
                                                    <th>TIME</th>
                                                    <th>STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            ${newRow}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>`;
                $("#tv_screen_show").append(tbl);
            } 
        });
    }
    </script>


<script>
    $(document).ready(function(){
        let urlParams = new URLSearchParams(window.location.search);
        let tvValue = urlParams.get('tv');

        if(tvValue == null || tvValue == ''){
            alert('TV ID Not Found!');
            return false;
        }
        $.ajax({
            url: "{{route('tv-screen.default-tv-data')}}/"+ tvValue,
            method: "get",
            success: function(response){
                dataShow(response);
            },
            error:function(err){
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message); 
            }
        })
    })
</script>

</body>
</html>
