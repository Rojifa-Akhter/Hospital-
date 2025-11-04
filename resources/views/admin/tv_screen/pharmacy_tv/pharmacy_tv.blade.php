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
            background-color: #0066B1;
            /* background-color: #0613d3; */
            margin-right: 1px;
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
            background-color: #008FCB;
            color: white;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #b2c8f7 ;
        }
        .table-striped tbody tr:nth-of-type(even) {
            background-color: #8bb7ff ;
        }
        .next_in_queue{
            background-color: white !important;
            color: black !important;
        }
        .time_over{
            background-color: red !important;
            color:white !important;
        }
        .bg-color{
              background-color: #37B4A6 !important;
        }
        .bg-color-even{
              background-color: #01D6A6 !important;
        }
    </style>
</head>
@php
    $hospitalInfo=DB::table('wsec_hospital')->where('status',1)->first();
@endphp
<header>
    <div class="form-row">
        <div class="col-md-12">
            <div class="login_note" >
                <img   style="background-color: transparent;width: 170px; padding:5px; " src="{{asset('images/uploads/hospital_images/'.Session::get('user.ses_hospital_logo'))}}">                
             <span style="font-size:50px; font-weight: 900;margin-left:25%">  Medicine Delivery Queue </span>
            </div>
             
        </div>        
    </div>
    
</header>
<body>

    <div class="row" id="tv_screen_show">
        
    </div>

    <script>
        // Pusher.logToConsole = true;
        
        // Initialize Pusher and Echo
        var pusher = new Pusher('08b2100d4e81edeabd10', {
        cluster: 'mt1',
        forceTLS: true,
	    enabledTransports: ['ws'], 
    });

    var channel = pusher.subscribe('PharmacyTVUpdate');
    

    // Listen to the TVUpdate event
    channel.bind('PharmacyTVUpdate', function(event) {
        dataShow(event);
        
    });

    // Log any errors
    channel.bind('pusher:error', function(error) {
        console.log('Error with Pusher:', error);
    });

    function dataShow(temp){
        console.log(temp)
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
                doctor_bg ="doctor-bg";// index % 2 == 0 ? "doctor-bg" : "doctor-bg-2";
                tbl = ``;
                newRow = ``;
                next_in_queue_index = 0;
                next_in_queue = 'next_in_queue';
                time_over = '';
                row.patient.forEach((item, index2) => {
                    if(item.movement_type_no == 1){
                        status = 'Processing';
                    }
                    else if(item.movement_type_no == 2){
                        status = 'Ready To Delivery';
                        if (index2 % 2 == 0) {
                            next_in_queue = 'bg-color-even';
                        }else{
                            next_in_queue = 'bg-color';
                        }
                       
                    }
                    else if(item.movement_type_no == 3){
                        status = 'Completed';
                    }


                    newRow+= `
                        <tr class="${item.movement_type_no == 2 ? next_in_queue : '' }">
                           
                            <td class='text-white'  style="text-align:center;font-size:22px">${item.token_no} </td>
                            <td class='text-white' style='font-size:22px'>${status}</td>
                        </tr>
                    `;
   
                })  
                // <div>(${row.patient.length})</div>
                tbl = `<div class="col-md-${cols} col-12 p-0 m-0">
                                <div class="card">
                                    <div class="card-header ${doctor_bg} text-white text-uppercase">
                                       <div style="display:flex;justify-content:space-between">
                                            <div style='font-size:22px;'>COUNTER NO: ${row.counter_no == null ? '<spna class="text-danger">Not Defined</span>' :  '<b>'+row.counter_name+'</b>'}</div>
                                            
                                        </div>
                                    </div>
                                    <div class="card-body p-1">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                               
                                                    <th class='text-center' style='font-size:22px'>QUEUE NO</th>
                                                    <th style='font-size:22px'>STATUS</th>
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
            url: "{{route('tv-screen.pharmacy-default-tv-data')}}/"+ tvValue,
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
